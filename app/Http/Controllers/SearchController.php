<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');
        $isAdmin = $request->get('is_admin', false);

        if (mb_strlen($query) < 2) {
            return response()->json([]);
        }

        $posts = Post::query()
            ->with('category')
            ->search($query)
            ->withSearchRank($query)
            ->orderBy('search_rank', 'desc')
            ->limit(10)
            ->get()
            ->map(function($post) use ($query, $isAdmin) {
                return [
                    'title' => $this->highlightText($post->title, $query),
                    'excerpt' => $this->highlightExcerpt($post->body, $query),
                    'category' => $this->highlightText($post->category->name, $query),
                    'url' => $isAdmin ? route('posts.edit', $post) : route('post.show', $post->slug),
                    'rank' => $post->search_rank
                ];
            });

        return response()->json($posts);
    }

    private function highlightText($text, $search)
    {
        if (empty($search)) {
            return $text;
        }

        // Create array of search terms
        $terms = explode(' ', preg_quote($search));

        // Normalize the text for comparison
        $normalizedText = $this->normalizeText($text);

        // Sort terms by length (longest first)
        usort($terms, function($a, $b) {
            return strlen($b) - strlen($a);
        });

        $positions = [];

        // Find all positions of matching terms (including accent-insensitive)
        foreach ($terms as $term) {
            $normalizedTerm = $this->normalizeText($term);
            $offset = 0;

            while (($pos = mb_stripos($normalizedText, $normalizedTerm, $offset)) !== false) {
                $length = mb_strlen($term);
                $positions[] = [
                    'start' => $pos,
                    'length' => $length
                ];
                $offset = $pos + $length;
            }
        }

        // Sort positions by start index
        usort($positions, function($a, $b) {
            return $a['start'] - $b['start'];
        });

        // Apply highlights from end to start to avoid position shifts
        $positions = array_reverse($positions);

        foreach ($positions as $pos) {
            $originalText = mb_substr($text, $pos['start'], $pos['length']);
            $text = mb_substr($text, 0, $pos['start'])
                . '<mark class="bg-yellow-200 p-0">' . $originalText . '</mark>'
                . mb_substr($text, $pos['start'] + $pos['length']);
        }

        return $text;
    }

    private function highlightExcerpt($text, $search)
    {
        // Remove HTML tags
        $text = strip_tags($text);

        // Find position of the first search term
        $pos = mb_stripos($text, $search);

        if ($pos === false) {
            // Try to find partial matches
            foreach (explode(' ', $search) as $term) {
                $pos = mb_stripos($text, $term);
                if ($pos !== false) break;
            }

            // If still no match, return start of text
            if ($pos === false) {
                return mb_substr($text, 0, 160) . '...';
            }
        }

        // Get surrounding context
        $start = max(0, $pos - 80);
        $length = 160;

        // Adjust start if we're in the middle of a word
        if ($start > 0) {
            $start = mb_strpos($text, ' ', $start) ?: $start;
        }

        $excerpt = mb_substr($text, $start, $length);

        // Add ellipsis if needed
        if ($start > 0) {
            $excerpt = '...' . $excerpt;
        }
        if (mb_strlen($text) > ($start + $length)) {
            $excerpt .= '...';
        }

        // Highlight the search terms in the excerpt
        return $this->highlightText($excerpt, $search);
    }

    private function normalizeText($text)
    {
        // Remove diacritics
        $text = preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml|caron);~i', '$1', htmlentities($text, ENT_QUOTES, 'UTF-8'));
        return mb_strtolower($text);
    }
}

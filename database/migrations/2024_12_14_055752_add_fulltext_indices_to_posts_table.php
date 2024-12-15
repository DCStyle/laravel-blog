<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddFulltextIndicesToPostsTable extends Migration
{
    public function up()
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            // Add normalized columns
            DB::statement('ALTER TABLE posts ADD normalized_title VARCHAR(255)');
            DB::statement('ALTER TABLE posts ADD normalized_excerpt TEXT');
            DB::statement('ALTER TABLE posts ADD normalized_body LONGTEXT');
            DB::statement('ALTER TABLE categories ADD normalized_name VARCHAR(255)');

            // Create function to remove accents
            DB::unprepared('
            CREATE FUNCTION remove_accents(str TEXT)
            RETURNS TEXT
            DETERMINISTIC
            NO SQL
            BEGIN
                SET str = REPLACE(str, "á", "a");
                SET str = REPLACE(str, "à", "a");
                SET str = REPLACE(str, "ã", "a");
                SET str = REPLACE(str, "ả", "a");
                SET str = REPLACE(str, "ạ", "a");
                SET str = REPLACE(str, "ă", "a");
                SET str = REPLACE(str, "ắ", "a");
                SET str = REPLACE(str, "ằ", "a");
                SET str = REPLACE(str, "ẵ", "a");
                SET str = REPLACE(str, "ẳ", "a");
                SET str = REPLACE(str, "ặ", "a");
                SET str = REPLACE(str, "â", "a");
                SET str = REPLACE(str, "ấ", "a");
                SET str = REPLACE(str, "ầ", "a");
                SET str = REPLACE(str, "ẫ", "a");
                SET str = REPLACE(str, "ẩ", "a");
                SET str = REPLACE(str, "ậ", "a");
                SET str = REPLACE(str, "é", "e");
                SET str = REPLACE(str, "è", "e");
                SET str = REPLACE(str, "ẽ", "e");
                SET str = REPLACE(str, "ẻ", "e");
                SET str = REPLACE(str, "ẹ", "e");
                SET str = REPLACE(str, "ê", "e");
                SET str = REPLACE(str, "ế", "e");
                SET str = REPLACE(str, "ề", "e");
                SET str = REPLACE(str, "ễ", "e");
                SET str = REPLACE(str, "ể", "e");
                SET str = REPLACE(str, "ệ", "e");
                SET str = REPLACE(str, "í", "i");
                SET str = REPLACE(str, "ì", "i");
                SET str = REPLACE(str, "ĩ", "i");
                SET str = REPLACE(str, "ỉ", "i");
                SET str = REPLACE(str, "ị", "i");
                SET str = REPLACE(str, "ó", "o");
                SET str = REPLACE(str, "ò", "o");
                SET str = REPLACE(str, "õ", "o");
                SET str = REPLACE(str, "ỏ", "o");
                SET str = REPLACE(str, "ọ", "o");
                SET str = REPLACE(str, "ô", "o");
                SET str = REPLACE(str, "ố", "o");
                SET str = REPLACE(str, "ồ", "o");
                SET str = REPLACE(str, "ỗ", "o");
                SET str = REPLACE(str, "ổ", "o");
                SET str = REPLACE(str, "ộ", "o");
                SET str = REPLACE(str, "ơ", "o");
                SET str = REPLACE(str, "ớ", "o");
                SET str = REPLACE(str, "ờ", "o");
                SET str = REPLACE(str, "ỡ", "o");
                SET str = REPLACE(str, "ở", "o");
                SET str = REPLACE(str, "ợ", "o");
                SET str = REPLACE(str, "ú", "u");
                SET str = REPLACE(str, "ù", "u");
                SET str = REPLACE(str, "ũ", "u");
                SET str = REPLACE(str, "ủ", "u");
                SET str = REPLACE(str, "ụ", "u");
                SET str = REPLACE(str, "ư", "u");
                SET str = REPLACE(str, "ứ", "u");
                SET str = REPLACE(str, "ừ", "u");
                SET str = REPLACE(str, "ữ", "u");
                SET str = REPLACE(str, "ử", "u");
                SET str = REPLACE(str, "ự", "u");
                SET str = REPLACE(str, "ý", "y");
                SET str = REPLACE(str, "ỳ", "y");
                SET str = REPLACE(str, "ỹ", "y");
                SET str = REPLACE(str, "ỷ", "y");
                SET str = REPLACE(str, "ỵ", "y");
                SET str = REPLACE(str, "đ", "d");
                RETURN LOWER(str);
            END
        ');

            // Create triggers for posts
            DB::unprepared('
            CREATE TRIGGER posts_before_insert BEFORE INSERT ON posts
            FOR EACH ROW
            BEGIN
                SET NEW.normalized_title = remove_accents(NEW.title);
                SET NEW.normalized_excerpt = remove_accents(NEW.excerpt);
                SET NEW.normalized_body = remove_accents(NEW.body);
            END
        ');

            DB::unprepared('
            CREATE TRIGGER posts_before_update BEFORE UPDATE ON posts
            FOR EACH ROW
            BEGIN
                SET NEW.normalized_title = remove_accents(NEW.title);
                SET NEW.normalized_excerpt = remove_accents(NEW.excerpt);
                SET NEW.normalized_body = remove_accents(NEW.body);
            END
        ');

            // Create triggers for categories
            DB::unprepared('
            CREATE TRIGGER categories_before_insert BEFORE INSERT ON categories
            FOR EACH ROW
            BEGIN
                SET NEW.normalized_name = remove_accents(NEW.name);
            END
        ');

            DB::unprepared('
            CREATE TRIGGER categories_before_update BEFORE UPDATE ON categories
            FOR EACH ROW
            BEGIN
                SET NEW.normalized_name = remove_accents(NEW.name);
            END
        ');

            // Update existing data
            DB::statement('UPDATE posts SET
            normalized_title = remove_accents(title),
            normalized_excerpt = remove_accents(excerpt),
            normalized_body = remove_accents(body)
        ');
            DB::statement('UPDATE categories SET normalized_name = remove_accents(name)');

            // Create fulltext indices
            DB::statement('ALTER TABLE posts ADD FULLTEXT search_index (title, excerpt, body)');
            DB::statement('ALTER TABLE posts ADD FULLTEXT normalized_search_index (normalized_title, normalized_excerpt, normalized_body)');
            DB::statement('ALTER TABLE categories ADD FULLTEXT category_search_index (name)');
            DB::statement('ALTER TABLE categories ADD FULLTEXT normalized_category_search_index (normalized_name)');
        }
        else if (DB::connection()->getDriverName() === 'pgsql') {
            // Create unaccent extension if not exists
            DB::statement('CREATE EXTENSION IF NOT EXISTS unaccent');

            // Create the vector column
            DB::statement('ALTER TABLE posts ADD COLUMN search_vector tsvector');

            // Create function to handle search including category name
            DB::statement('
                CREATE OR REPLACE FUNCTION posts_trigger() RETURNS trigger AS $$
                DECLARE
                    category_name text;
                BEGIN
                    SELECT c.name INTO category_name
                    FROM categories c
                    WHERE c.id = NEW.category_id;

                    NEW.search_vector :=
                        setweight(to_tsvector(\'simple\', unaccent(coalesce(NEW.title,\'\'))), \'A\') ||
                        setweight(to_tsvector(\'simple\', unaccent(coalesce(NEW.excerpt,\'\'))), \'B\') ||
                        setweight(to_tsvector(\'simple\', unaccent(coalesce(NEW.body,\'\'))), \'C\') ||
                        setweight(to_tsvector(\'simple\', unaccent(coalesce(category_name,\'\'))), \'A\');
                    return NEW;
                END
                $$ LANGUAGE plpgsql;
            ');

            // Create trigger
            DB::statement('
                CREATE TRIGGER posts_vector_update
                BEFORE INSERT OR UPDATE ON posts
                FOR EACH ROW EXECUTE FUNCTION posts_trigger()
            ');

            // Update existing records
            DB::statement('
                UPDATE posts p SET search_vector =
                    setweight(to_tsvector(\'simple\', unaccent(coalesce(p.title,\'\'))), \'A\') ||
                    setweight(to_tsvector(\'simple\', unaccent(coalesce(p.excerpt,\'\'))), \'B\') ||
                    setweight(to_tsvector(\'simple\', unaccent(coalesce(p.body,\'\'))), \'C\') ||
                    setweight(to_tsvector(\'simple\', unaccent(coalesce(c.name,\'\'))), \'A\')
                FROM categories c
                WHERE c.id = p.category_id
            ');
        }
    }

    public function down()
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            // Drop triggers
            DB::unprepared('DROP TRIGGER IF EXISTS posts_before_insert ON posts');
            DB::unprepared('DROP TRIGGER IF EXISTS posts_before_update ON posts');
            DB::unprepared('DROP TRIGGER IF EXISTS categories_before_insert ON categories');
            DB::unprepared('DROP TRIGGER IF EXISTS categories_before_update ON categories');

            // Drop function
            DB::unprepared('DROP FUNCTION IF EXISTS remove_accents');

            // Drop indices
            DB::statement('ALTER TABLE posts DROP INDEX IF EXISTS search_index');
            DB::statement('ALTER TABLE posts DROP INDEX IF EXISTS normalized_search_index');
            DB::statement('ALTER TABLE categories DROP INDEX IF EXISTS category_search_index');
            DB::statement('ALTER TABLE categories DROP INDEX IF EXISTS normalized_category_search_index');

            // Drop columns
            DB::statement('ALTER TABLE posts DROP COLUMN IF EXISTS normalized_title');
            DB::statement('ALTER TABLE posts DROP COLUMN IF EXISTS normalized_excerpt');
            DB::statement('ALTER TABLE posts DROP COLUMN IF EXISTS normalized_body');
            DB::statement('ALTER TABLE categories DROP COLUMN IF EXISTS normalized_name');
        } else if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('DROP TRIGGER IF EXISTS posts_vector_update ON posts');
            DB::statement('DROP FUNCTION IF EXISTS posts_trigger');
            DB::statement('DROP INDEX IF EXISTS posts_search_idx');
            DB::statement('ALTER TABLE posts DROP COLUMN IF EXISTS search_vector');
        }
    }
}

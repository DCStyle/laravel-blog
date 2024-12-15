import './bootstrap';
import.meta.glob(['../images/**']);
import './theme';
import 'flowbite';

window.confirmDelete = function (id, name) {
    Swal.fire({
        title: 'Bạn có chắc muốn xoá mục này?',
        text: "Việc xoá sẽ không thể khôi phục lại dữ liệu!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xoá',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            const element = document.getElementById(`${name}_${id}`);
            if (element) {
                element.submit();
            } else {
                console.error(`Element with ID ${name}_${id} not found.`);
            }
        }
    });
}

window.cannot = function (message) {
    Swal.fire(
        'Lỗi',
        message,
        'error'
    );
}

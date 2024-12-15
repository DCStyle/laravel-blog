const modal = document.querySelector('.modal');
if (modal) {
    const profileModal = modal.querySelector(".modal-profile");
    const notificationModal = modal.querySelector(".modal-notifications");
    const notificationsCountElement = document.querySelector(".notifications_count");
    const isZero = notificationsCountElement ? parseInt(notificationsCountElement.innerHTML) === 0 : false;
    const isEmpty = notificationModal?.querySelector(".empty") !== null;
    let sentReadNotifications = isZero || isEmpty;

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('modal') && modal.style.display === 'flex') {
            modal.style.display = 'none';
            document.body.style.overflow = "auto";
        }
    });

    const profileButton = document.querySelector('.profile');
    if (profileButton) {
        profileButton.addEventListener('click', function (event) {
            modal.style.display = 'flex';
            document.body.style.overflow = "hidden";
            if (event.target.classList.contains('notifications_count')) {
                profileModal?.classList.add("hidden");
                notificationModal?.classList.remove("hidden");
                readNotifications();
            } else {
                profileModal?.classList.remove("hidden");
                notificationModal?.classList.add("hidden");
            }
        });
    }

    const closeModalButton = document.querySelector('.close.close-modal');
    if (closeModalButton) {
        closeModalButton.addEventListener('click', function () {
            modal.style.display = 'none';
            document.body.style.overflow = "auto";
        });
    }

    const backButton = document.querySelector('.modal-notifications .back');
    if (backButton) {
        backButton.addEventListener('click', function () {
            profileModal?.classList.remove("hidden");
            notificationModal?.classList.add("hidden");
        });
    }

    const date = Date.now();

    window.readNotifications = function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) return;

        if (!sentReadNotifications) {
            fetch('/read-notifications', {
                method: 'PATCH',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ 'date': date }),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Kết nối mạng không ổn định');
                    }
                    if (response.status === 200) {
                        sentReadNotifications = true;
                        if (notificationsCountElement) notificationsCountElement.innerHTML = "0";
                        const modalProfileNotifications = document.querySelector(".modal-profile .notifications");
                        if (modalProfileNotifications) {
                            modalProfileNotifications.innerHTML = "0 <i class=\"fa-solid fa-angles-right\"></i>";
                        }
                    }
                })
                .catch(error => {
                    console.error('Đã xảy ra lỗi trong quá trình xử lý yêu cầu:', error);
                });
        }
    }

    window.clearNotifications = function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken || !notificationModal) return;

        const notifications = notificationModal.querySelectorAll(".notification");
        const dateElements = document.querySelectorAll(".modal-notifications .date");
        fetch('/clear-notifications', {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Kết nối mạng không ổn định');
                }
                if (response.status === 200) {
                    notifications.forEach(notification => notification.remove());
                    dateElements.forEach(dateElement => dateElement.remove());
                    const notificationDiv = document.createElement('div');
                    notificationDiv.classList.add('notification', 'action');

                    const paragraph = document.createElement('p');
                    paragraph.classList.add('empty');
                    paragraph.textContent = 'Không có thông báo';
                    notificationDiv.appendChild(paragraph);
                    notificationModal.appendChild(notificationDiv);
                }
            })
            .catch(error => {
                console.error('Đã xảy ra lỗi trong quá trình xử lý yêu cầu:', error);
            });
    }
}

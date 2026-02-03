const dataTable = document.querySelector("#dataTable");
const deleteForm = document.querySelector(".delete-form");
const bulkDeleteBtn = document.querySelector("#bulk-delete-btn");
const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute("content") : "";
const getMasterCheckbox = () => document.querySelector("#check-all");

const getSelectedIds = () =>
    Array.from(document.querySelectorAll(".row-check:checked")).map(
        (item) => item.value
    );

    
const updateBulkDeleteState = () => {
    if (!bulkDeleteBtn) {
        return;
    }
    const hasSelection = getSelectedIds().length > 0;
    bulkDeleteBtn.disabled = !hasSelection;
};

window.updateBulkDeleteState = updateBulkDeleteState;

if (dataTable && deleteForm) {
    dataTable.addEventListener("click", (event) => {
        const deleteBtn = event.target.closest(".delete-action");
        if (!deleteBtn) {
            return;
        }

        event.preventDefault();
        const action = deleteBtn.dataset.url || deleteBtn.getAttribute("href");
        if (!action) {
            return;
        }

        Swal.fire({
            title: "Bạn có chắc chắn?",
            text: "Nếu xóa bạn không thể khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "OK, Đồng ý xoá!",
        }).then((result) => {
            if (result.isConfirmed) {
                deleteForm.action = action;
                deleteForm.submit();
            }
        });
    });
}

document.addEventListener("change", (event) => {
    if (event.target.id === "check-all") {
        const isChecked = event.target.checked;
        document.querySelectorAll(".row-check").forEach((checkbox) => {
            checkbox.checked = isChecked;
        });
        updateBulkDeleteState();
        return;
    }

    if (event.target.classList.contains("row-check")) {
        const masterCheckbox = getMasterCheckbox();
        if (masterCheckbox && !event.target.checked) {
            masterCheckbox.checked = false;
        }
        updateBulkDeleteState();
    }
});

if (bulkDeleteBtn) {
    bulkDeleteBtn.addEventListener("click", () => {
        const ids = getSelectedIds();
        if (ids.length === 0) {
            Swal.fire(
                "Thông báo",
                "Vui lòng chọn ít nhất 1 người dùng",
                "info"
            );
            return;
        }

        const deleteUrl = bulkDeleteBtn.dataset.url;
        if (!deleteUrl) {
            return;
        }

        Swal.fire({
            title: "Bạn có chắc chắn?",
            text: `Bạn sắp xóa ${ids.length} người dùng. Hành động không thể hoàn tác!`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "OK, Đồng ý xoá!",
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            fetch(deleteUrl, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({ ids }),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error();
                    }
                    return response.json();
                })
                .then((data) => {
                    Swal.fire(
                        "Thành công",
                        data.message || "Đã xóa thành công",
                        "success"
                    );
                    if (window.userDataTable) {
                        window.userDataTable.ajax.reload(null, false);
                    } else if (
                        window.jQuery &&
                        $.fn.DataTable &&
                        $.fn.DataTable.isDataTable("#dataTable")
                    ) {
                        $("#dataTable").DataTable().ajax.reload(null, false);
                    }
                    const masterCheckbox = getMasterCheckbox();
                    if (masterCheckbox) {
                        masterCheckbox.checked = false;
                    }
                    document
                        .querySelectorAll(".row-check")
                        .forEach((checkbox) => {
                            checkbox.checked = false;
                        });
                    updateBulkDeleteState();
                })
                .catch(() => {
                    Swal.fire(
                        "Lỗi",
                        "Không thể xóa người dùng. Vui lòng thử lại!",
                        "error"
                    );
                });
        });
    });
}
function convertToSlug(text) {
    return text
        .toLowerCase()
        .normalize("NFD") // tách dấu
        .replace(/[\u0300-\u036f]/g, "") // xóa dấu
        .replace(/[^a-z0-9\s-]/g, "") // xóa ký tự đặc biệt
        .trim()
        .replace(/\s+/g, "-") // thay khoảng trắng bằng -
        .replace(/-+/g, "-"); // gộp dấu - liên tiếp
}


// Auto generate slug when typing name
document.getElementById("name").addEventListener("keyup", function () {
    document.getElementById("slug").value = convertToSlug(this.value);
});
$(document).ready(function() {
    // Kiểm tra xem element có tồn tại không trước khi chạy để tránh lỗi
    if ($('.js-example-basic-single').length > 0) {
        $('.js-example-basic-single').select2();
    }
});
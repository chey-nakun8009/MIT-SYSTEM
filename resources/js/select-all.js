console.log('load select-all.js');

window.initSelectAll = function (config = {}) {
    const selectAll = document.getElementById(config.selectAllId);
    const tableBody = document.getElementById(config.tableBodyId);

    if (!selectAll || !tableBody) {
        return;
    }

    function getCheckboxes() {
        return tableBody.querySelectorAll(
            config.checkboxSelector || '.user-checkbox'
        );
    }

    function updateSelectAllState() {
        const checkboxes = getCheckboxes();

        if (!checkboxes.length) {
            selectAll.checked = false;
            selectAll.indeterminate = false;
            return;
        }

        const checkedCount = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .length;

        selectAll.checked = checkedCount === checkboxes.length;
        selectAll.indeterminate =
            checkedCount > 0 &&
            checkedCount < checkboxes.length;
    }

    selectAll.addEventListener('change', function () {
        const checkboxes = getCheckboxes();

        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });

        selectAll.indeterminate = false;
    });

    tableBody.addEventListener('change', function (e) {
        const checkbox = e.target.closest(
            config.checkboxSelector || '.user-checkbox'
        );

        if (!checkbox) {
            return;
        }

        updateSelectAllState();
    });

    updateSelectAllState();
};
let inactiveAdmin;

document.addEventListener("DOMContentLoaded", function () {
  const gridDiv = document.querySelector('#inactiveAdmins');
  fetch('group1/inactive_admins').then(response => {
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  }).then(data => {
    const gridOptions = {
      defaultColDef: {
        flex: 2,
        headerClass: 'fw-bold roboto-regular',
        cellClass: 'roboto-regular',
        filter: true,
      },
      domLayout: 'autoHeight',
      rowData: data,
      columnDefs: [
        { field: 'id', headerName: 'User ID', flex: 1},
        { field: 'name', cellClass: 'fw-semibold'},
        { field: 'email'},
        { field: 'updated_at', headerName: 'Deactivated'},
        {
          headerName: 'Actions',
          field: 'actions',
          cellRenderer: (params) => {
            const flexHead = `<div class="d-flex flex-row gap-2 w-100 align-items-center justify-content-end mb-0 p-0 h-100">`;
            const deleteButton = 
            `<button class="btn btn-sm btn-red px-3" style="font-size: 12px;" onclick="deleteAdmin('${params.data.id}')">
              <i class="bi bi-trash3-fill me-1"></i>
              Delete
            </button>`;
            const restoreButton = 
            `<button class="btn btn-sm btn-navy px-3" style="font-size: 12px;" onclick="restoreAdmin('${params.data.id}')">
              <i class="bi bi-arrow-clockwise me-1"></i>
              Restore
            </button>`;
            const flexFoot = `</div>`;
            const html = flexHead + deleteButton + restoreButton + flexFoot;
            return html;
          },
          cellStyle: { textAlign: 'right' },
          flex: 1.5,
        },
      ],
      pagination: true,
      paginationPageSize: 50,
    }
    inactiveAdmin = agGrid.createGrid(gridDiv, gridOptions);
  }).catch(error => console.error('Error fetching row data: ', error));
});   

function inactiveAdminSearch() {
  const searchValue = document.getElementById('inactiveAdminSearch').value;
  inactiveInstructor.setGridOption(
    "quickFilterText",
    searchValue,
  );
}

function deleteAdmin(id) {
  alert(`Permanently Delete admin with ID: ${id}`);
}

function restoreAdmin(id) {
  window.location.href = `/group1/archive_restore_admin?id=${id}`;
}
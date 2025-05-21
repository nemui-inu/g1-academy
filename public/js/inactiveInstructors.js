let inactiveInstructor;

document.addEventListener("DOMContentLoaded", function () {
  const gridDiv = document.querySelector('#inactiveInstructors');
  fetch('group1/inactive_instructors').then(response => {
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
            `<button class="btn btn-sm btn-red px-3" style="font-size: 12px;" onclick="deleteInstructor('${params.data.id}')">
              <i class="bi bi-trash3-fill me-1"></i>
              Delete
            </button>`;
            const restoreButton = 
            `<button class="btn btn-sm btn-navy px-3" style="font-size: 12px;" onclick="restoreInstructor('${params.data.id}')">
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
    inactiveInstructor = agGrid.createGrid(gridDiv, gridOptions);
  }).catch(error => console.error('Error fetching row data: ', error));
});   

function instructorInactiveSearch() {
  const searchValue = document.getElementById('inactiveInstructorSearch').value;
  inactiveInstructor.setGridOption(
    "quickFilterText",
    searchValue,
  );
}

function deleteInstructor(id) {
  alert(`Permanently Delete instructor with ID: ${id}`);
}

function restoreInstructor(id) {
  window.location.href = `/group1/archive_restore_instructor?id=${id}`;
}
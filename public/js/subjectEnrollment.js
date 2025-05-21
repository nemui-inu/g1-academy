// (~) Inactive Students

let enroTable;

document.addEventListener("DOMContentLoaded", function () {
  const gridDiv = document.querySelector('#enroTable');
  fetch('group1/inactive_students').then(response => {
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  }).then(data => {
    const gridOptions = {
      defaultColDef: {
        flex: 1,
        headerClass: 'fw-bold roboto-regular',
        cellClass: 'roboto-regular',
        filter: true,
      },
      domLayout: 'autoHeight',
      rowData: data,
      columnDefs: [
        { field: 'studentID'},
        { field: 'name', cellClass: 'fw-semibold'},
        { field: 'course'},
        { field: 'yearLevel'},
        {
          headerName: 'Actions',
          field: 'actions',
          cellRenderer: (params) => {
            const flexHead = `<div class="d-flex flex-row gap-2 w-100 align-items-center justify-content-end mb-0 p-0 h-100">`;
            const restoreButton = 
            `<button class="btn btn-sm btn-navy px-3" style="font-size: 12px;" onclick="restoreStudent('${params.data.studentID}')">
              Details
            </button>`;
            const deleteButton = 
            `<button class="btn btn-sm btn-red px-3" style="font-size: 12px;" onclick="deleteStudent('${params.data.studentID}')">
              Unenroll
            </button>`;
            const flexFoot = `</div>`;
            const html = flexHead + restoreButton + deleteButton + flexFoot;
            return html;
          },
          flex: 1.65,
          cellStyle: { textAlign: 'right' },
        },
      ],
      pagination: true,
      paginationPageSize: 50,
    }
    enroTable = agGrid.createGrid(gridDiv, gridOptions);
  }).catch(error => console.error('Error fetching row data: ', error));
});   

function onSearchBarInput() {
  const searchValue = document.getElementById('inactiveStudentSearch').value;
  inactiveTable.setGridOption(
    "quickFilterText",
    searchValue,
  );
}

function deleteStudent(studentId) {
  alert(`Permanently Delete student with ID: ${studentId}`);
}

function restoreStudent(studentId) {
  window.location.href = `/group1/students-view?id=${studentId}`;
}

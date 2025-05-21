// (~) Inactive Students

let inactiveTable;

document.addEventListener("DOMContentLoaded", function () {
  const gridDiv = document.querySelector('#studentsEnroll');
  fetch('group1/enrollment_list').then(response => {
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  }).then(data => {
    const gridOptions = {
      defaultColDef: {
        flex: 3,
        headerClass: 'fw-bold roboto-regular',
        cellClass: 'roboto-regular',
        filter: true,
      },
      domLayout: 'autoHeight',
      rowData: data,
      columnDefs: [
        { field: 'studentID', flex: 1},
        { field: 'name', cellClass: 'fw-semibold'},
        {
          headerName: 'Actions',
          field: 'actions',
          cellRenderer: (params) => {
            const flexHead = `<div class="d-flex flex-row gap-2 w-100 align-items-center justify-content-end mb-0 p-0 h-100">`;
            const enrollButton = 
            `<button class="btn btn-sm btn-green fw-semibold text-white px-3" style="font-size: 12px;" onclick="restoreStudent('${params.data.studentID}')">
              Enroll
              <i class="bi bi-plus ms-1"></i>
            </button>`;
            const flexFoot = `</div>`;
            const html = flexHead + enrollButton + flexFoot;
            return html;
          },
          flex: 1,
          cellStyle: { textAlign: 'right' },
        },
      ],
      pagination: true,
      paginationPageSize: 50,
    }
    inactiveTable = agGrid.createGrid(gridDiv, gridOptions);
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
  window.location.href = `/group1/archive_restore_student?id=${studentId}`;
}

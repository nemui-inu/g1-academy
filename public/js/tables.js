let gridApi;

document.addEventListener("DOMContentLoaded", function () {
  const gridDiv = document.querySelector('#studentTable');
  fetch('group1/studenttable').then(response => {
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
        { field: 'gender', cellClass: 'text-capitalize'},
        { field: 'birthdate'},
        { field: 'course'},
        { field: 'yearLevel'},
        {
          headerName: 'Actions',
          field: 'actions',
          cellRenderer: (params) => {
            const viewButton = `<button class="btn btn-sm btn-navy px-3" style="font-size: 12px;" onclick="viewStudent('${params.data.studentID}')">View</button>`;
            const editButton = `<button class="btn btn-sm btn-yellow-2 px-3 text-navy" style="font-size: 12px;" onclick="editStudent('${params.data.studentID}')">Edit</button>`;
            const deactivateButton = `<button class="btn btn-sm btn-red px-3" style="font-size: 12px;" onclick="deactivateStudent('${params.data.studentID}')">Deactivate</button>`;
            return viewButton + ' ' + editButton + ' ' + deactivateButton;
          },
          flex: 1.65,
          cellStyle: { textAlign: 'right' },
        },
      ],
      pagination: true,
      paginationPageSize: 50,
    }
    gridApi = agGrid.createGrid(gridDiv, gridOptions);
  }).catch(error => console.error('Error fetching row data: ', error));
});   

function onSearchBarInput() {
  const searchValue = document.getElementById('searchBar').value;
  gridApi.setGridOption(
    "quickFilterText",
    searchValue,
  );
}

function viewStudent(studentId) {
  alert(`View student with ID: ${studentId}`);
}

function editStudent(studentId) {
  alert(`Edit student with ID: ${studentId}`);
}

function deactivateStudent(studentId) {
  alert(`Deactivate student with ID: ${studentId}`);
}
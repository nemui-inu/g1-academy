let instructorTable;

// (~) Active Students

document.addEventListener("DOMContentLoaded", function () {
  const gridDiv = document.querySelector('#instructorsTable');
  fetch('group1/instructors_table').then(response => {
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
        { field: 'role', flex: 1},
        {
          headerName: 'Actions',
          field: 'actions',
          cellRenderer: (params) => {
            const viewButton = `<button class="btn btn-sm btn-navy px-3" style="font-size: 12px;" onclick="viewInstructor('${params.data.id}')">View</button>`;
            const editButton = `<button class="btn btn-sm btn-yellow-2 px-3 text-navy" style="font-size: 12px;" onclick="editInstructor('${params.data.id}')">Edit</button>`;
            const deleteButton = `<button class="btn btn-sm btn-red px-3" style="font-size: 12px;" onclick="deleteInstructor('${params.data.id}')">Delete</button>`;
            return viewButton + ' ' + editButton + ' ' + deleteButton;
          },
          cellStyle: { textAlign: 'right' },
          flex: 1.5,
        },
      ],
      pagination: true,
      paginationPageSize: 50,
    }
    instructorTable = agGrid.createGrid(gridDiv, gridOptions);
  }).catch(error => console.error('Error fetching row data: ', error));
});   

function searchInstructorTable() {
  const searchValue = document.getElementById('searchInstructors').value;
  coursesTable.setGridOption(
    "quickFilterText",
    searchValue,
  );
}

function viewInstructor(id) {
  window.location.href = `/group1/instructor-view?id=${id}`;
}

function editInstructor(id) {
  window.location.href = `/group1/instructor-edit?id=${id}`;
}

function deleteInstructor(id) {
  window.location.href = `/group1/instructor-delete?id=${id}`;
}
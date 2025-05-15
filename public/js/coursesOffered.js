let coursesTable;

// (~) Active Students

document.addEventListener("DOMContentLoaded", function () {
  const gridDiv = document.querySelector('#coursesOffered');
  fetch('group1/courses_offered').then(response => {
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
        { field: 'id', hide: true, },
        { field: 'code', headerName: 'Course Code', flex: 1},
        { field: 'name', headerName: 'Course Name', cellClass: 'fw-semibold', flex: 3},
        { field: 'enrolled', headerName: 'Enrolled', cellClass: 'roboto-mono-regular'},
        {
          headerName: 'Actions',
          field: 'actions',
          cellRenderer: (params) => {
            const viewButton = `<button class="btn btn-sm btn-navy px-3" style="font-size: 12px;" onclick="viewCourse('${params.data.id}')">View</button>`;
            const editButton = `<button class="btn btn-sm btn-yellow-2 px-3 text-navy" style="font-size: 12px;" onclick="editCourse('${params.data.id}')">Edit</button>`;
            const deleteButton = `<button class="btn btn-sm btn-red px-3" style="font-size: 12px;" onclick="deleteCourse('${params.data.id}')">Delete</button>`;
            return viewButton + ' ' + editButton + ' ' + deleteButton;
          },
          cellStyle: { textAlign: 'right' },
          flex: 1.5,
        },
      ],
      pagination: true,
      paginationPageSize: 50,
    }
    coursesTable = agGrid.createGrid(gridDiv, gridOptions);
  }).catch(error => console.error('Error fetching row data: ', error));
});   

function searchCoursesTable() {
  const searchValue = document.getElementById('searchCourses').value;
  coursesTable.setGridOption(
    "quickFilterText",
    searchValue,
  );
}

function viewCourse(id) {
  window.location.href = `/group1/courses-view?id=${id}`;
}

function editCourse(id) {
  window.location.href = `/group1/courses-edit?id=${id}`;
}

function deleteCourse(id) {
  window.location.href = `/group1/courses-delete?id=${id}`;
}
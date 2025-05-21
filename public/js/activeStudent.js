let activeStudentTable;

document.addEventListener("DOMContentLoaded", function () {
  const gridDiv = document.querySelector('#activeStudents');
  fetch('group1/active_students').then(response => {
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  }).then(data => {
    const gridOptions = {
      rowHeight: 30,
      defaultColDef: {
        flex: 2,
        headerClass: 'fw-bold roboto-regular',
        cellClass: 'roboto-regular',
        filter: true,
        sortable: true,
        resizable: true,
      },
      domLayout: 'autoHeight',
      rowData: data,
      columnDefs: [
        { field: "studentID", headerName: "Student ID" },
        { field: "name", headerName: "Name", cellClass: "fw-semibold" },
        { field: 'gender', cellClass: 'text-capitalize'},
        { field: 'birthdate'},
        { field: "course", headerName: "Course" },
        { field: "yearLevel", headerName: "Year Level" },
        {
          headerName: 'Actions',
          field: 'actions',
          cellRenderer: (params) => {
            const studentId = params.data.studentID;
            const viewButton = `<button class="btn btn-sm btn-navy px-3" style="font-size: 12px;" onclick="viewStudent('${studentId}')">View</button>`;
            const editButton = `<button class="btn btn-sm btn-yellow-2 px-3 text-navy" style="font-size: 12px;" onclick="editStudent('${studentId}')">Edit</button>`;
            const deactivateButton = `<button class="btn btn-sm btn-red px-3" style="font-size: 12px;" onclick="deactivateStudent('${studentId}')">Deactivate</button>`;
            return viewButton + ' ' + editButton + ' ' + deactivateButton;
          },
          minWidth: 320,
          flex: 2,
        },
      ],
      pagination: true,
      paginationPageSize: 5,
    };
      activeStudentTable = agGrid.createGrid(gridDiv, gridOptions);
      document.getElementById("active-students-message").textContent = "";
    })
    .catch(error => {
      console.error("Error fetching pending grading tasks:", error);
      document.getElementById("active-students-message").textContent = "Failed to load data.";
    });
});   

function searchActiveStudentTable() {
  const searchValue = document.getElementById('searchBar').value;
  if (activeStudentTable) {
    activeStudentTable.api.setQuickFilter(searchValue);
  }
}

function viewStudent(studentId) {
  window.location.href = `/group1/students-view?id=${studentId}`;
}

function editStudent(studentId) {
  window.location.href = `/group1/students-edit?id=${studentId}`;
}

function deactivateStudent(studentId) {
  window.location.href = `/group1/students-deactivatestudent?id=${studentId}`;
}

function exportToPDF() {
  window.open('/group1/reports/students_report.php', '_blank');
}

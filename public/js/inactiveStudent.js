let inactiveStudentTable;

document.addEventListener("DOMContentLoaded", function () {
  const gridDiv = document.querySelector('#inactiveStudents');
  fetch('group1/inactive_students').then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
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
          { field: "course", headerName: "Course" },
          { field: "yearLevel", headerName: "Year Level" },
          { field: "updated_at", headerName: "Deactivated" },
          {
            headerName: "Actions",
            field: "actions",
            cellRenderer: (params) => {
              const studentId = params.data.studentID;
              const deleteButton = `<button class="btn btn-sm btn-red px-3" style="font-size: 12px;" onclick="deleteStudent('${studentId}')">
                                      <i class="bi bi-trash3-fill me-1"></i>Delete
                                    </button>`;
              const restoreButton = `<button class="btn btn-sm btn-navy px-3" style="font-size: 12px;" onclick="restoreStudent('${studentId}')">
                                       <i class="bi bi-arrow-clockwise me-1"></i>Restore
                                     </button>`;
              return deleteButton + ' ' + restoreButton;
            },
            minWidth: 280,
            flex: 2,
            cellClass: 'text-end',
          },
        ],
        pagination: true,
        paginationPageSize: 5,
      };

      inactiveStudentTable = agGrid.createGrid(gridDiv, gridOptions);
      document.getElementById("inactive-students-message").textContent = "";
    })
    .catch(error => {
      console.error("Error fetching inactive students:", error);
      document.getElementById("inactive-students-message").textContent = "Failed to load data.";
    });
});

function searchInactiveStudentTable() {
  const searchValue = document.getElementById('inactiveStudentSearch').value;
  inactiveStudentTable.setGridOption("quickFilterText", searchValue);
}

function deleteStudent(studentId) {
  alert(`Permanently delete student with ID: ${studentId}`);
  // Add API request here if needed
}

function restoreStudent(studentId) {
  window.location.href = `/group1/archive_restore_student?id=${studentId}`;
}

function exportToPDF() {
  window.open('/group1/reports/inactive_students_report.php', '_blank');
}

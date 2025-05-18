let pendingGradingTable;

document.addEventListener("DOMContentLoaded", function () {
  const instructorId = document.querySelector("#pendingGradingGrid").dataset.instructorId;
  const gridDiv = document.querySelector("#pendingGradingGrid");

  fetch(`group1/pending_grading_details`)
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      const gridOptions = {
        defaultColDef: {
          flex: 2,
          headerClass: "fw-bold roboto-regular",
          cellClass: "roboto-regular",
          sortable: true,
          resizable: true,
        },
        rowData: data,
        columnDefs: [
          { field: "student_id", headerName: "Student ID" },
          { field: "name", headerName: "Name", cellClass: "fw-semibold" },
          { field: "year_level", headerName: "Year Level" },
          { field: "course_code", headerName: "Course" },
          { field: "subject_code", headerName: "Subject" },
          {
            field: "grade",
            headerName: "Grade",
            valueFormatter: (params) => params.value !== null ? params.value : "N/A"
          },
          { field: "remarks", headerName: "Remarks" },
        ],
        pagination: true,
        paginationPageSize: 5,
        domLayout: "autoHeight",
      };

      pendingGradingTable = agGrid.createGrid(gridDiv, gridOptions);
      document.getElementById("pending-grading-message").textContent = "";
    })
    .catch(error => {
      console.error("Error fetching pending grading tasks:", error);
      document.getElementById("pending-grading-message").textContent = "Failed to load data.";
    });
});
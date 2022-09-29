<div class="container p-2">
    <!-- Reports -->
    <div class="col-12 mb-16">
      <div class="card">

        <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
              <h6>Filter</h6>
            </li>

            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
          </ul>
        </div>

        <div class="card-body">
          <h5 class="card-title">Reports <span>/Today</span></h5>

          <!-- Line Chart -->
          <div id="reportsChart"></div>

          <script>
            document.addEventListener("DOMContentLoaded", () => {
              new ApexCharts(document.querySelector("#reportsChart"), {
                series: [{
                  name: 'Client1',
                  data: [31, 40, 28, 51, 42, 82, 56],
                }, {
                  name: 'Client2',
                  data: [11, 32, 45, 32, 34, 52, 41]
                }, {
                  name: 'Client3',
                  data: [15, 11, 32, 18, 9, 24, 11]
                }],
                chart: {
                  height: 350,
                  type: 'area',
                  toolbar: {
                    show: false
                  },
                },
                markers: {
                  size: 4
                },
                colors: ['#4154f1', '#2eca6a', '#ff771d'],
                fill: {
                  type: "gradient",
                  gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.4,
                    stops: [0, 90, 100]
                  }
                },
                dataLabels: {
                  enabled: false
                },
                stroke: {
                  curve: 'smooth',
                  width: 2
                },
                xaxis: {
                  type: 'datetime',
                  categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
                },
                tooltip: {
                  x: {
                    format: 'dd/MM/yy HH:mm'
                  },
                }
              }).render();
            });
          </script>
          <!-- End Line Chart -->

        </div>

      </div>
    </div>
    <!-- End Reports -->
    <!-- Paid / Unpaid Box table -->

    <!-- Table template for Report -->
    <div>
        <h2>Demo Table for Report</h2>
        <table class="table table-hover text-center">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Client Name</th>
              <th scope="col">Paid Box</th>
              <th scope="col">Unpaid Box</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>H.Slot</td>
              <td>
                <div class="col-sm-10 m-auto">
                  <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                  </select>
                </div>
              </td>
              <td>
                <div class="col-sm-10 m-auto">
                  <select class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                  </select>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
    </div>
    <!-- End Table with stripped rows -->


     <!-- Table with stripped rows -->
    <div class="mt-16">
        <h2>Demo Table for Report</h2>
        <table class="table table-hover">
        <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Position</th>
              <th scope="col">Age</th>
              <th scope="col">Start Date</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Brandon Jacob</td>
              <td>Designer</td>
              <td>28</td>
              <td>2016-05-25</td>
            </tr>
          </tbody>
        </table>
    </div>
    <!-- End Table with stripped rows -->
</div>
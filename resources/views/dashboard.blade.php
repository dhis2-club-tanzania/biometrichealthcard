<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
                <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper max-w-7xl mx-auto sm:px-6 lg:px-8">
    <!-- Content Header (Page header) -->
    <div class="content-header">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>{{ $member }}</h3>

                  <p>Total Members</p>
                </div>
                <div class="icon info-box-icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="nhifmembers" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>{{ $fingerprint }}</h3>

                  <p>Fingerprints</p>
                </div>
                <div class="icon">
                    <i class="fas fa-fingerprint"></i>
                </div>
                <a href="fingerprints" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>{{$percentage}}<sup style="font-size: 20px">%</sup></h3>

                  <p>Weekly Registrations</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>95</h3>

                  <p>Auth. Success Rate</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Weekly Recap Report</h5>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item">Something else here</a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <p class="text-center">
                      {{-- <img src="dist/img/graph1.png" alt="User Image"> --}}
                      <canvas id="chart" style="position: relative; height:50vh; width:70vw"></canvas>
                    </p>

                    {{-- <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <canvas id="salesChart" height="180" style="height: 180px;" class="chartjs-render-monitor"></canvas>

                    </div> --}}
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <p class="text-center">
                      <strong>Goal Completion</strong>
                    </p>

                    <div class="progress-group">
                        Auth Success Rate
                        <span class="float-right"><b>95</b>/100</span>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-danger" style="width: 95%"></div>
                        </div>
                      </div>
                      <!-- /.progress-group -->

                      <div class="progress-group">
                        <span class="progress-text">Fingerprints</span>
                        <span class="float-right"><b>90</b>/100</span>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-success" style="width: 90%"></div>
                        </div>
                      </div>
                      <!-- /.progress-group -->

                    <div class="progress-group">
                      Registration of fingerprints
                      <span class="float-right"><b>45.45</b>/100</span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" style="width: 45.45%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group">
                        Members
                        <span class="float-right"><b>22</b>/100</span>
                        <div class="progress progress-sm">
                          <div class="progress-bar bg-primary" style="width: 22%"></div>
                        </div>
                      </div>
                      <!-- /.progress-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                      {{-- <h5 class="description-header">$35,210.43</h5>
                      <span class="description-text">TOTAL REVENUE</span> --}}
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                      {{-- <h5 class="description-header">$10,390.90</h5>
                      <span class="description-text">TOTAL COST</span> --}}
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-down"></i> 10%</span>
                      {{-- <h5 class="description-header">$24,813.53</h5>
                      <span class="description-text">TOTAL PROFIT</span> --}}
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                      <span class="description-percentage text-danger"><i class="fas fa-caret-up"></i> 18%</span>
                      {{-- <h5 class="description-header">1200</h5>
                      <span class="description-text">GOAL COMPLETIONS</span> --}}
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
            </div>
        </div>
    </div>

     {{-- graph --}}
     <script>
        var data = <?php echo json_encode($data); ?>;

        var ctx = document.getElementById('chart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
        });
    </script>

    <!-- Core -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>

    <!-- Theme JS -->
    <script src="../assets/js/argon-dashboard.min.js"></script>


</x-app-layout>

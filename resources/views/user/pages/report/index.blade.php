@extends('user.app')

@section('content')
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="font-size: 1.9rem">Reports</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Report Name</th>
                                    <th>Report Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Count of temporary links</td>
                                    <td>{{ $countTemporaryLinks }}</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Count of visited temporary links</td>
                                    <td>{{ $countVisitedTemporaryLinks }}</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Count of trashed files</td>
                                    <td>{{ $countTrashedFiles }}</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Count of existing files</td>
                                    <td>{{ $countExistingFiles }}</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Count of views on links</td>
                                    <td>{{ $countLinksViews }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>


        </div>
    </section>
@endsection

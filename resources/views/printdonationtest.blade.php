<!doctype html>
<html lang="ar">

<head>

    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" />


    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Icons Css -->
    <link rel="stylesheet" href="{{asset('assets/css/print.css')}}">
<style>
    body{
        font-family: "Droid Arabic Kufi", "Droid Sans", sans-serif;
    }
</style>
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>



            <div class="container-fluid mt-lg-5">

                <div class="row w-80 mx-auto" id="print-content">
                    <div class="col-12 ">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="invoice-title">
                                            <h4 class="float-end center_name"><strong>{{$donation->center->name}}</strong></h4>
                                            <h3>
                                                <img src="{{asset('assets/logo/k.png')}}" alt="logo" height="60" width="60"/>
                                            </h3>
                                        </div>
                                        <hr>
<h6 class="text-center center_name">Donor: {{$donation->donor->user->name}}</h6>
                                        <div class="row">
                                            <div class="col-6">

                                                <address>
                                                    <strong>Test Type:</strong><br>

                                                    hepatitis_b:<br>
                                                    hepatitis_b:<br>
                                                    syphilis_result:<br>
                                                    malaria_result:<br>
                                                    Blood Group:

                                                </address>
                                            </div>
                                            <div class="col-6 text-end">
                                                <address>
                                                    <strong>Test Result</strong><br>
                                                    {{$tr->hepatitis_b_result ?? ' '}}<br>
                                                    {{$tr->hepatitis_c_result?? ' '}}<br>
                                                    {{$tr->syphilis_result?? ' '}}<br>
                                                    {{$tr->malaria_result?? ' '}}<br>
                                                     {{$donation->donor->bloodType->blood_type?? ' '}}

                                                </address>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mt-4">
                                                <address>

                                                    @if($tr && $tr->note)
                                                    <strong>Doctor Message:</strong><br>
                                                   {{$tr->note}}
                                                    @endif
                                                </address>
                                            </div>
                                            <div class="col-6 mt-4 text-end">
                                                <address>
                                                    <strong>Donation Date:</strong><br>
                                                    {{$donation->donation_date}}<br><br>
                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->






<script>
    // Call the print function as soon as the page has finished loading
    window.onload = function() {
        // Get the row element
        var row = document.getElementById("print-content");
        // Print the row element
        print(row);
    };
</script>
</body>
</html>

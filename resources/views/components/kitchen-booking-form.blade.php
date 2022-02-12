
<div class="row">
    <div class="col-sm-12">
    <table class="display table table-striped table-bordered table-hover" cellspacing="0"
    width="100%">
    <thead>
        <tr>
            <th>Ryhmä</th>
            <th>Aloitusaika</th>
            <th>Lopetusaika</th>
    
        </tr>
    </thead>
    
    <tbody>
        @foreach ($bookings as $item)
        <tr>
            <td>{{$item->group_name}}</td>
            <td>{{Carbon\Carbon::parse($item->start_time)->format('d.m.Y \K\l\o H:i')}}</td>
            <td>{{Carbon\Carbon::parse($item->end_time)->format('d.m.Y \K\l\o H:i')}}</td>
        </tr>
            
        @endforeach
    </tbody>
    </table>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#KitchenModal">
            Varaa
        </button>
    </div>
</div>
<div class="modal fade" id="KitchenModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle">Varaa keittiövuoro</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="{{route('kitchenBooking.store')}}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Varaaja: </label>
                            <div class="col-sm-8">
                                <input name="booker" class="form-control" placeholder="{{Auth::user()->name}}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Ryhmän nimi: </label>
                            <div class="col-sm-8">
                                <input class="form-control" name="group-name" placeholder="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Aloitusaika: </label>
                            <div class="col-sm-8">
                                <input class="form-control" type="datetime-local" id="start-time" name="start-time"
                                    value="{{Carbon\Carbon::now()->format('Y-m-d\TH:i')}}" min="{{Carbon\Carbon::now()->format('Y-m-d\TH:i')}}" max="{{Carbon\Carbon::now()->addYear()->format('Y-m-d\TH:i')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Lopetusaika: </label>
                            <div class="col-sm-8">
                                <input class="form-control" type="datetime-local" id="end-time" name="end-time"
                                value="{{Carbon\Carbon::now()->addHour()->format('Y-m-d\TH:i')}}" min="{{Carbon\Carbon::now()->addHour()->format('Y-m-d\TH:i')}}" max="{{Carbon\Carbon::now()->addYear()->format('Y-m-d\TH:i')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-primary">Varaa</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>

    </script>
@endpush

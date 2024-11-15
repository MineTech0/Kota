<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="exampleModalLongTitle">{{ $loan->equipment->name }} laina
                @if(Carbon\Carbon::createFromFormat('d/m/Y',$loan->return_date)->lt(Carbon\Carbon::now()))
                    <span class="badge badge-danger">Myöhässä</span>
                @endif
                @if($loan->state==0)
                    <span class="badge badge-primary">Hyväksytty</span>
                @elseif($loan->state==1)
                    <span class="badge badge-info">Odottaa hyväksyntää</span>
                @elseif($loan->state==2)
                    <span class="badge badge-success">Hyväksytty</span>
                @else
                    <span class="badge badge-warning">Ei hyväksytty</span>
                @endif</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
        </div>
        <div class="modal-body">
            @if ($loan->equipment->picture)
            <div class="form-group row">
            <img src="storage/{{ $loan->equipment->picture }}" class="img-thumbnail rounded mx-auto d-block" width="200"> 
            </div>
            @endif
            <div class="form-group row">
                <label  class="col-sm-3 col-form-label">Varuste: </label>
                <div class="col-sm-8">
                    <input class="form-control"  placeholder="{{ $loan->equipment->name }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label  class="col-sm-3 col-form-label">Sarjanumero: </label>
                <div class="col-sm-8">
                    <input class="form-control"  placeholder="{{ $loan->equipment->serial }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label  class="col-sm-3 col-form-label">Kunto: </label>
                <div class="col-sm-8">
                    <input class="form-control"  placeholder="{{ $loan->equipment->form }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label  class="col-sm-3 col-form-label">Paikka: </label>
                <div class="col-sm-8">
                    <input class="form-control"  placeholder="{{ $loan->equipment->location }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label  class="col-sm-3 col-form-label">Laina-aika: </label>
                <div class="col-sm-4">
                    <input class="form-control"  placeholder="{{ $loan->loan_date }}" disabled>
                </div>
                <label class="col-form-label">-</label>
                <div class="col-sm-4">
                    <input class="form-control"  placeholder="{{ $loan->return_date }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label  class="col-sm-3 col-form-label">Määrä: </label>
                <div class="col-sm-8">
                    <input class="form-control"  placeholder="{{ $loan->quantity }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label  class="col-sm-3 col-form-label">Mihin: </label>
                <div class="col-sm-8">
                    <input class="form-control"  placeholder="{{ $loan->reason }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label  class="col-sm-3 col-form-label">Kuvaus: </label>
                <div class="col-sm-8">
                    <textarea class="form-control"  placeholder="{{ $loan->desc }}" disabled
                        rows="8"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3"></div>
                <div class="col-sm-8">
                    @if ($loan->state==1)
                        <button type="button" class="btn btn-primary btn-block returnBtn" data-id="{{$loan->id}}" data-message="Poistettu">Poista</button >
                    @elseif($loan->state == 3)
                        <button type="button" class="btn btn-primary btn-block returnBtn" data-id="{{$loan->id}}" data-message="Poistettu">Poista</button >
                    @else 
                        <button type="button" class="btn btn-primary btn-block returnBtn" data-id="{{$loan->id}}" data-message="Palautettu">Palauta</button >
                    @endif
                
                </div>
            </div>
            <div class="alert returnInfo" style="display: none"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sulje</button>
        </div>
    </div>
</div>

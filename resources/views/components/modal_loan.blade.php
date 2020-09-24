<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="exampleModalLongTitle">{{ $loan->equipment->name }} laina</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
        </div>
        <div class="modal-body">
          <div class="alert returnInfo" style="display: none">Palautettu</div>
          @if ($loan->equipment->picture)
          <div class="form-group row">
          <img src="storage/{{ $loan->equipment->picture }}" class="img-thumbnail rounded mx-auto d-block" width="200"> 
          </div>
          @endif
            <div class="form-group row">
                <label  class="col-sm-3 col-form-label">Lainaaja: </label>
                <div class="col-sm-8">
                    <input class="form-control"  placeholder="{{ $loan->user->name }}" disabled>
                </div>
            </div>
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
                <div class="col-sm-4">
                <button type="button" class="btn btn-success btn-block acceptBtn" data-id="{{$loan->id}}" data-state="2">Hyväksy laina</button >
                </div>
                <div class="col-sm-4">
                <button type="button" class="btn btn-danger btn-block acceptBtn" data-id="{{$loan->id}}" data-state="3">Hylkää laina</button >
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sulje</button>
        </div>
    </div>
</div>

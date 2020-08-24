<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Ota yhteyttä</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
            <label  class="col-sm-3 col-form-label">Puhelinnumero: </label>
            <div class="col-sm-8">
                <input class="form-control"  placeholder="{{ $contact->number }}" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label  class="col-sm-3 col-form-label">Sähköposti: </label>
            <div class="col-sm-8">
                <input class="form-control"  placeholder="{{ $contact->email }}" readonly>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sulje</button>
      </div>
    </div>
  </div>
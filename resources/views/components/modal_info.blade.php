
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">{{$loan->equipment->name}} laina</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <h5><b>{{$loan->equipment->name}}</b></h5>
      <h5><b>{{$loan->equipment->serial}}</b></h5>
      <h5>Laina päivä: <b>{{$loan->loan_date}}</b></h5>
      <h5>Palautus päivä: <b>{{$loan->return_date}}</b></h5>
      <h5>Määrä: <b>{{$loan->quantity}}</b></h5>
      <h5>Mihin: <b>{{$loan->reason}}</b></h5>
      <h5>Selitys:</h5>
      <p style="word-break: break-word;">{{$loan->desc}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sulje</button>
      </div>
    </div>
  </div>
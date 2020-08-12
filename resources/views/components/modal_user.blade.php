<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="exampleModalLongTitle">Muokkaa rooleja</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
        </div>
        <div class="modal-body">
            @if ($user->hasRole('super-admin'))
            <div class="alert roleInfo alert-danger"">Super-adminta ei voi muokata</div>
            @else
            <div class="alert roleInfo" style="display: none"></div>
            @endif

          <div class="form-group row">
              <label  class="col-sm-3 col-form-label">Nimi: </label>
              <div class="col-sm-6">
                  <input class="form-control"  placeholder="{{ $user->name }}" disabled>
              </div>
          </div>
              
            <div class="form-group row">
                @foreach ($user->roles as $index => $role)
                @if ($index==0)
                    <label  class="col-sm-3 col-form-label">Roolit: </label>  
                @else 
                    <div class="col-sm-3"></div>
                @endif
                    <div class="col-sm-6 mb-2">
                        <input class="form-control"  placeholder="{{ucfirst($role->name)}}" disabled>         
                    </div>
                    <div class="col-sm-2 mb-2">
                    <button type="button" class="btn btn-danger btn-sm delBtn" data-role="{{$role->id}}" data-id="{{$user->id}}">Poista</button>

                    </div>
                @endforeach
            </div>
            <hr/>
            
            <h3>Lisää rooli</h3>
        <form action="{{route('update.user', $user->id)}}" method="post">
            @method('patch')
            @csrf
            <input type="text" name="id" value="{{$user->id}}" hidden></input>
            <div class="form-group row">
                <label  class="col-sm-3 col-form-label">Rooli: </label>
                <div class="col-sm-6">
                    <select class="form-control" name="roleSelect" id="roleSelect">
                        @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>  
                        @endforeach
                      </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-info btn-block">Lisää</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Sulje</button>
        </div>
    </div>
</div>

<hr>
<h3>Wybierz konto:</h2>

<div class="row">
     @foreach ($accounts as $account)
        <div class="mb-4">
            <label>
                <div class="form-check"><input name="accounts[]" type="checkbox" value="{{ $account->id }}"
                    @if($server->accounts->contains($account->id)) checked=checked @endif>
                    {{ $account->service }} ( {{$account->signature }} )
                </div>
            </label>
        </div>
     @endforeach
</div>
<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Zapisz</button>

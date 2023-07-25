<div>
    <form wire:submit.prevent='gantiPassword'>
        <div class="form-group">
            <label for="">Password</label>
            <input type="password" wire:model.defer='password' name="" id="" class="form-control @error('password') is-invalid @enderror">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="">Konfirmasi Password</label>
            <input type="password" wire:model.defer='password_confirmation' name="" id="" class="form-control @error('password_confirmation') is-invalid @enderror">
            @error('passord_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<?php

namespace App\Http\Livewire\Profile;

use App\Traits\SwalResponse;
use Livewire\Component;

class DataDiri extends Component
{
    use SwalResponse;

    public $user;
    public $password, $password_confirmation;

    public function render()
    {
        return view('livewire.profile.data-diri');
    }

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function gantiPassword()
    {
        $this->validate([
            'password' => 'required|confirmed'
        ],[
            'password.required' => 'Password tidak boleh kosong',
            'password.confirmed' => 'Password tidak sama'
        ]);

        try{
            $this->user->password = bcrypt($this->password);
            $this->user->save();
            $this->reset(['password', 'password_confirmation']);
            $this->dispatchBrowserEvent('swal:toast', $this->toastResponse('Password berhasil diubah'));
        }catch(\Exception $e){
            $this->dispatchBrowserEvent('swal:toast', $this->toastResponse($e->getMessage(), 'error'));
        }
    }
}

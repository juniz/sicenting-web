<?php

namespace App\Http\Livewire\Units;

use Livewire\Component;
use App\Models\Unit;
use App\Traits\SwalResponse;

class Table extends Component
{
    use SwalResponse;

    public $units;
    protected $listeners = ['delete', 'refresh'];

    public function render()
    {
        return view('livewire.units.table');
    }

    public function mount()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->units = Unit::all();
    }

    public function setUpdate($id)
    {
        $this->emit('setUpdate', $id);
    }

    public function hapus($id)
    {
        $this->dispatchBrowserEvent('swal:confirm', $this->swalConfirmDialog('delete', [$id]));
    }

    public function delete($id)
    {
        try{

            $unit = Unit::find($id);
            $unit->delete();
            $this->refresh();
            $this->dispatchBrowserEvent('swal', $this->toastResponse('Data berhasil dihapus'));

        }catch(\Exception $ex){
            $this->dispatchBrowserEvent('swal', $this->toastResponse($ex->getMessage() ?? 'Data gagal dihapus', 'error'));
        }
    }
}

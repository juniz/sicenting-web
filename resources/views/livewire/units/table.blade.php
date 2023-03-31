<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tableUnits" class="table table-striped table-inverse" style="width: 100%">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($units as $unit)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $unit->nama }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" wire:click="setUpdate('{{$unit->id}}')">Edit</button>
                                <button wire:click="hapus('{{$unit->id}}')" class="btn btn-danger btn-sm">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", ()=>{
            Livewire.hook('element.updating', (fromEl, toEl, component) => {
                if (fromEl.id == 'tableUnits') {
                    $('#tableUnits').DataTable().destroy();
                }
            })
            Livewire.hook('element.updated', (el, component) => {
                if (el.id == 'tableUnits') {
                    $('#tableUnits').DataTable();
                }
            })
        })

        $('#tableUnits').DataTable();

        window.addEventListener('swal:confirm',function(e){
                Swal.fire({
                    title: e.detail.title,
                    text: e.detail.text,
                    icon: e.detail.icon,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: e.detail.confirmButtonText,
                    cancelButtonText: e.detail.cancelButtonText,
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.livewire.emit(e.detail.function, e.detail.params[0]);
                    }
                });
        });
    </script>
@endpush

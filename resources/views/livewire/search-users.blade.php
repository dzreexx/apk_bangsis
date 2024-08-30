<div>
    <form wire:submit.prevent="render">
        <input type="text" wire:model.debounce.500ms="search" placeholder="Cari pengguna...">
    </form>

    @if(count($users) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NRP</th>
                    <th>Satker</th>
                    <th>Pangkat</th>
                    <th>Korp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->nrp }}</td>
                        <td>{{ $user->satker }}</td>
                        <td>{{ $user->pangkat }}</td>
                        <td>{{ $user->korp }}</td>
                        <td>
                            <form action="{{ route('admin.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada pengguna yang ditemukan.</p>
    @endif
</div>

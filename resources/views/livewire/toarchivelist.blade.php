<div>
    <script>
        function hide_modal(element_id){
            var myModalEl = document.getElementById(element_id);
            var modal = bootstrap.Modal.getInstance(myModalEl)
            modal.hide();
        }
        Livewire.on('itemAdded', postId => {
           hide_modal('addNewItemModal');
        });

        Livewire.on('itemRemoved', postId => {
            hide_modal('removeItemModal');
        });
    </script>

    <!-- Modal -->

    <div wire:ignore.self class="modal fade" id="removeItemModal" tabindex="-1" aria-labelledby="removeItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeItemModalLabel">Remove from list 'to archive'</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete this item? It will also delete archived posts from this subreddit!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click="delete()" class="btn btn-danger" data-bs-dismiss="modal">Yes, Delete</button>
                </div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewItemModal">
        <i class="bi bi-plus-square"></i> Add new
    </button>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Type</th>
            <th scope="col">Created at</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($archive_list as $element)
            <tr>
                <th scope="row">{{$element->id}}</th>
                <td>{{$element->name}}</td>
                <td>{{$element->type}}</td>
                <td>{{$element->created_at}}</td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm"><i class="bi bi-pen"></i> Edit</button>
                    <button type="button" class="btn btn-danger btn-sm" wire:click="deleteId({{$element->id}})"
                            data-bs-toggle="modal" data-bs-target="#removeItemModal">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $archive_list->links() !!}
</div>



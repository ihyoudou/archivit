<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="addNewItemModal" tabindex="-1" aria-labelledby="addNewItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewItemModalLabel">Add new item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="submit">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Enter subreddit or username name"
                                   wire:model="item_name" aria-label="item name to archive" aria-describedby="basic-addon1">
                        </div>
                        @error('item_name') <span class="error">{{ $message }}</span> @enderror

                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Type</label>
                            <select class="form-select" id="inputGroupSelect01" wire:model="item_type">
                                <option selected>Choose...</option>
                                <option value="subreddit">Subreddit</option>
                                <option value="user">User profile</option>
                            </select>
                        </div>
                        @error('item_type') <span class="error">{{ $message }}</span> @enderror



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
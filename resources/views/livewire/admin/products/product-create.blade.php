<div class="modal fade show" style="display: block; background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 16px;">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold">Create New Product</h5>
                <button type="button" class="btn-close" wire:click="cancel"></button>
            </div>
            <form wire:submit.prevent="save">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Product Name -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Product Name *</label>
                            <input type="text" class="form-control" wire:model="name" 
                                   placeholder="Enter product name"
                                   style="border-radius: 8px;">
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea class="form-control" rows="3" wire:model="description" 
                                      placeholder="Describe your product..."
                                      style="border-radius: 8px; resize: none;"></textarea>
                            @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Category and Product Type -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category *</label>
                            <select class="form-select" wire:model="category" style="border-radius: 8px;">
                                <option value="">Select Category</option>
                                <option value="food">Food</option>
                                <option value="drinks">Drinks</option>
                                <option value="equipment">Equipment</option>
                                <option value="experience">Experience</option>
                            </select>
                            @error('category') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Product Type *</label>
                            <select class="form-select" wire:model="product_type" style="border-radius: 8px;">
                                <option value="">Select Type</option>
                                <option value="upsell">Upsell</option>
                                <option value="addon">Add-on</option>
                            </select>
                            @error('product_type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Price -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Price (CHF) *</label>
                            <div class="input-group">
                                <span class="input-group-text">CHF</span>
                                <input type="number" class="form-control" wire:model="price" 
                                       step="0.01" min="0"
                                       style="border-radius: 0 8px 8px 0;">
                            </div>
                            @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Stock Management Toggle -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stock Management</label>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" wire:model="manage_stock" id="manage_stock">
                                <label class="form-check-label" for="manage_stock">
                                    Track inventory for this product
                                </label>
                            </div>
                        </div>

                        <!-- Stock Fields (shown only if manage_stock is true) -->
                        @if($manage_stock)
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Stock Quantity *</label>
                                <input type="number" class="form-control" wire:model="stock_quantity" 
                                       min="0"
                                       style="border-radius: 8px;">
                                @error('stock_quantity') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Low Stock Alert *</label>
                                <input type="number" class="form-control" wire:model="low_stock_threshold" 
                                       min="0"
                                       style="border-radius: 8px;">
                                <small class="text-muted">Alert when stock falls below this number</small>
                                @error('low_stock_threshold') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        @endif

                        <!-- Image Upload -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Product Image</label>
                            <input type="file" class="form-control" wire:model="image" 
                                   accept="image/*"
                                   style="border-radius: 8px;">
                            <small class="text-muted">Maximum file size: 2MB. Supported formats: JPG, PNG, GIF</small>
                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            
                            @if ($image)
                                <div class="mt-2">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" 
                                         class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                                </div>
                            @endif
                        </div>

                        <!-- Active Status -->
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="is_active" id="is_active">
                                <label class="form-check-label fw-semibold" for="is_active">
                                    Active (Available for purchase)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4">
                    <button type="button" class="btn btn-outline-secondary" wire:click="cancel"
                            style="border-radius: 8px;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary"
                            style="background: #c02425; border-color: #c02425; border-radius: 8px;">
                        <i class="fas fa-save me-2"></i>Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
# TODO: Remove Location Logic from Product Creation

## Tasks
- [ ] Create migration to add ville_id and commune_id to products table
- [ ] Update Product model: remove location_id from fillable, add ville_id and commune_id, update relationships
- [ ] Modify ProductController's store method: remove location check, add validation for ville_id and commune_id, set them in product creation
- [ ] Update create.blade.php: add select fields for ville and commune
- [ ] Update edit.blade.php: add select fields for ville and commune
- [ ] Update other product-related views and controllers to use villes and communes instead of location (except home page)
- [ ] Test product creation and editing

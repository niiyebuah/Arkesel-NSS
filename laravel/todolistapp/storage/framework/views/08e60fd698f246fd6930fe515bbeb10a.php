<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0"><?php echo e($todo->title); ?></h2>
                </div>
                <div class="card-body">
                    <div class="todo-details">
                        <div class="todo-section">
                            <h4 class="todo-detail">Name</h4>
                            <p class="todo-value"><?php echo e($todo->name); ?></p>
                        </div>
                        <hr class="todo-divider">
                        <div class="todo-section">
                            <h4 class="todo-detail">Description</h4>
                            <p class="todo-value"><?php echo e($todo->description); ?></p>
                        </div>
                        <hr class="todo-divider">
                        <div class="todo-section">
                            <h4 class="todok-detail">Date & Time</h4>
                            <p class="todo-value"><?php echo e($todo->created_at); ?></p>
                        </div>
                    </div>
                    <form id="deleteForm" action="<?php echo e(route('todo.destroy', $todo->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="button" class="btn btn-success btn-sm mr-2" onclick="showConfirmation()">Complete</button>
                        <button type="button" class="btn btn-warning btn-sm mr-2" onclick="showEditForm()">Edit</button>
                        <a href="/" class="btn btn-info btn-sm mr-2">View To-Do List</a>
                    </form>

                       <!-- Confirmation Popup -->
                       <div id="confirmationPopup" class="confirmation-popup" style="display: none;">
                            <p>This action will delete from To-Do List. Are you sure?</p>
                            <button type="button" class="btn btn-danger btn-sm mr-2" onclick="confirmDelete()">Yes</button>
                            <button class="btn btn-secondary btn-sm mr-2" onclick="hideConfirmation()">No</button>
                        </div>

                    <!-- Edit Form Modal -->
                    <div id="editFormModal" class="modal" tabindex="-1" role="dialog" style="display: none;">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Task</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="hideEditForm()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="editForm" class="edit-form" action="<?php echo e(route('todo.update', $todo->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="mb-3">
                                            <label for="editName" class="form-label">Edit Task Name:</label>
                                            <input type="text" class="form-control" id="editName" name="editName" value="<?php echo e($todo->name); ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="editTitle" class="form-label">Edit Task Title:</label>
                                            <input type="text" class="form-control" id="editTitle" name="editTitle" value="<?php echo e($todo->title); ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="editDescription" class="form-label">Edit Task Description:</label>
                                            <textarea class="form-control" id="editDescription" name="editDescription" rows="4"><?php echo e($todo->description); ?></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm mr-2">Save Changes</button>
                                        <button type="button" class="btn btn-secondary btn-sm mr-2" onclick="hideEditForm()">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
      function confirmDelete() {
        if (confirmDelete) {
            // If user clicks 'OK', proceed with form submission
            document.forms["deleteForm"].submit();
        } else {
            // If user clicks 'Cancel', hide the confirmation popup
            document.getElementById("confirmationPopup").style.display = "none";
        }
        // If user clicks 'Yes', proceed with form submission
    }


    function showEditForm() {
        console.log("Showing Edit Form...");
        var editFormModal = document.getElementById("editFormModal");
        editFormModal.style.display = "block";
    }

    function hideEditForm() {
        console.log("Hiding Edit Form...");
        var editFormModal = document.getElementById("editFormModal");
        editFormModal.style.display = "none";
    }

    function hideConfirmation() {
        console.log("Hiding Confirmation...");
        var confirmationPopup = document.getElementById("confirmationPopup");
        confirmationPopup.style.display = "none";
    }

    function showConfirmation() {
        console.log("Showing Confirmation...");
        var confirmationPopup = document.getElementById("confirmationPopup");
        confirmationPopup.style.display = "block";
    }
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/aaronadom-malm/Desktop/laravel/todolistapp/resources/views/todo/view.blade.php ENDPATH**/ ?>
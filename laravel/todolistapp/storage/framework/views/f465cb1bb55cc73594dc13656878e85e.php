<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">To-Do List</h2>
                </div>
                <div class="card-body">
                    <h4><a href="/create" class="btn btn-success btn-sm mr-2">New To-Do List</a></h4>
                    <?php $__empty_1 = true; $__currentLoopData = $todos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $todo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="todo-item mt-4 border p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="mb-0"><a href="/<?php echo e($todo->id); ?>" class="text-decoration-none text-dark"><?php echo e($todo->name); ?></a></h4>
                                <span class="text-muted">Created on: <?php echo e($todo->created_at->format('F j, Y \a\t h:i A')); ?></span>
                            </div>
                            <hr class="my-2">
                            <p class="mb-2"><?php echo e($todo->description); ?></p>
                            <div class="d-flex justify-content-end">
                                <a href="/<?php echo e($todo->id); ?>" class="btn btn-info btn-sm mr-2">See More</a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="mt-4">All tasks on To-Do list have been completed.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/aaronadom-malm/Desktop/laravel/todolistapp/resources/views/todo/index.blade.php ENDPATH**/ ?>
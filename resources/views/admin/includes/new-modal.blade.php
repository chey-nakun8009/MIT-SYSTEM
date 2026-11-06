<div class="modal fade" id="iconDemoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-palette me-2"></i>
                    Icon System Demo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" x-data="iconDemo">
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="mb-1">Bootstrap Icons <span class="badge bg-primary">subset</span></h6>
                        <p class="text-muted small mb-0">
                            Icons are referenced by semantic name (<code>dashboard</code>, <code>success</code>)
                            and resolved to Bootstrap Icons classes by the icon manager. Only the icons actually
                            used are compiled into the CSS subset.
                        </p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-3 text-center">
                        <div class="p-3 border rounded">
                            <i class="bi bi-speedometer2 icon-xl text-primary mb-2"></i>
                            <br><small>Dashboard</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="p-3 border rounded">
                            <i class="bi bi-people icon-xl text-success mb-2"></i>
                            <br><small>Users</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="p-3 border rounded">
                            <i class="bi bi-graph-up icon-xl text-info mb-2"></i>
                            <br><small>Analytics</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="p-3 border rounded">
                            <i class="bi bi-gear icon-xl text-warning mb-2"></i>
                            <br><small>Settings</small>
                        </div>
                    </div>
                </div>

                <h6 class="mt-4">Icon Animations</h6>
                <div class="row g-3">
                    <div class="col-md-3 text-center">
                        <i class="bi bi-arrow-clockwise icon-xl icon-spin text-primary"></i>
                        <br><small>Spin</small>
                    </div>
                    <div class="col-md-3 text-center">
                        <i class="bi bi-heart icon-xl icon-pulse text-danger"></i>
                        <br><small>Pulse</small>
                    </div>
                    <div class="col-md-3 text-center">
                        <i class="bi bi-star icon-xl icon-hover text-warning"></i>
                        <br><small>Hover Effect</small>
                    </div>
                    <div class="col-md-3 text-center">
                        <i class="bi bi-check-circle icon-xl text-success"></i>
                        <br><small>Static</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="newItemModal" tabindex="-1" aria-labelledby="newItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" id="newItemModalLabel">
                    <i class="bi bi-plus-circle text-primary me-2"></i>
                    Quick Add
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" x-data="quickAddForm()">
                <p class="text-muted small mb-4">Create a new item quickly from the dashboard.</p>

                <!-- Item Type Selection -->
                <div class="mb-4">
                    <label class="form-label fw-semibold">What would you like to add?</label>
                    <div class="btn-group w-100" role="group">
                        <button type="button" class="btn btn-outline-primary btn-sm"
                            :class="{ 'active': itemType === 'task' }" @click="itemType = 'task'">
                            <i class="bi bi-check2-square"></i> Task
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm"
                            :class="{ 'active': itemType === 'note' }" @click="itemType = 'note'">
                            <i class="bi bi-sticky"></i> Note
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm"
                            :class="{ 'active': itemType === 'event' }" @click="itemType = 'event'">
                            <i class="bi bi-calendar-event"></i> Event
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-sm"
                            :class="{ 'active': itemType === 'reminder' }" @click="itemType = 'reminder'">
                            <i class="bi bi-bell"></i> Reminder
                        </button>
                    </div>
                </div>

                <!-- Title -->
                <div class="mb-3">
                    <label for="itemTitle" class="form-label fw-semibold">Title</label>
                    <input type="text" class="form-control" id="itemTitle" x-model="title"
                        placeholder="Enter a title..." autofocus>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="itemDescription" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control" id="itemDescription" rows="3" x-model="description"
                        placeholder="Add some details..."></textarea>
                </div>

                <!-- Priority (shown for tasks) -->
                <div class="mb-3" x-show="itemType === 'task'" x-transition>
                    <label class="form-label fw-semibold d-block">Priority</label>
                    <div class="btn-group" role="group" aria-label="Priority selection">
                        <input type="radio" class="btn-check" name="priorityRadio" id="priorityLow"
                            value="low" x-model="priority" autocomplete="off">
                        <label class="btn btn-outline-success btn-sm" for="priorityLow">
                            <i class="bi bi-flag"></i> Low
                        </label>
                        <input type="radio" class="btn-check" name="priorityRadio" id="priorityMedium"
                            value="medium" x-model="priority" autocomplete="off">
                        <label class="btn btn-outline-warning btn-sm" for="priorityMedium">
                            <i class="bi bi-flag-fill"></i> Medium
                        </label>
                        <input type="radio" class="btn-check" name="priorityRadio" id="priorityHigh"
                            value="high" x-model="priority" autocomplete="off">
                        <label class="btn btn-outline-danger btn-sm" for="priorityHigh">
                            <i class="bi bi-flag-fill"></i> High
                        </label>
                    </div>
                </div>

                <!-- Date (shown for events/reminders) -->
                <div class="mb-3" x-show="itemType === 'event' || itemType === 'reminder'" x-transition>
                    <label for="itemDate" class="form-label fw-semibold">Date & Time</label>
                    <input type="datetime-local" class="form-control" id="itemDate" x-model="dateTime">
                </div>

                <!-- Assign to (shown for tasks) -->
                <div class="mb-3" x-show="itemType === 'task'" x-transition>
                    <label for="assignTo" class="form-label fw-semibold">Assign to</label>
                    <select class="form-select" id="assignTo" x-model="assignee">
                        <option value="">Select team member...</option>
                        <option value="john">John Doe</option>
                        <option value="jane">Jane Smith</option>
                        <option value="mike">Mike Johnson</option>
                        <option value="sarah">Sarah Williams</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" @click="saveItem()" data-bs-dismiss="modal">
                    <i class="bi bi-check-lg me-1"></i> Create Item
                </button>
            </div>
        </div>
    </div>
</div>

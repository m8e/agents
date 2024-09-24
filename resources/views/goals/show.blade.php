<x-panel-layout>
    <x-slot name="title">
        {{ $goal->title }}
    </x-slot>

    <div class="uk-container uk-margin-large-top">

        <!-- Goal Overview Section -->
        <div class="uk-card uk-card-default uk-card-body uk-margin-medium-bottom">
            <h3 class="uk-card-title">Goal Overview</h3>
            <dl class="uk-description-list">
                <dt>Goal Name:</dt>
                <dd>Convert Repository from Python to PHP</dd>

                <dt>Description:</dt>
                <dd>Migrate the codebase while maintaining architecture.</dd>

                <dt>Status:</dt>
                <dd>In Progress</dd>

                <dt>Type:</dt>
                <dd>Workflow-based</dd>

                <dt>One-shot:</dt>
                <dd>No</dd>
            </dl>
        </div>

        <!-- Workflow Status Section -->
        <div class="uk-card uk-card-default uk-card-body uk-margin-medium-bottom">
            <h3 class="uk-card-title">Workflow Status</h3>
            <ul class="uk-list uk-list-divider">
                <li>Planning - <span class="uk-label uk-label-success">Completed</span></li>
                <li>Automated Conversion - <span class="uk-label uk-label-success">Completed</span></li>
                <li>Manual Refactoring - <span class="uk-label uk-label-warning">In Progress</span></li>
                <li>Testing - <span class="uk-label uk-label-muted">Pending</span></li>
                <li>Deployment - <span class="uk-label uk-label-muted">Pending</span></li>
            </ul>
        </div>

        <!-- Tasks List Section -->
        <div class="uk-card uk-card-default uk-card-body uk-margin-medium-bottom">
            <h3 class="uk-card-title">Tasks & Progress</h3>
            <table class="uk-table uk-table-divider">
                <thead>
                <tr>
                    <th>Task</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Analyze Repository</td>
                    <td><span class="uk-label uk-label-success">Completed</span></td>
                    <td><button class="uk-button uk-button-primary">View Details</button></td>
                </tr>
                <tr>
                    <td>Convert Core Modules</td>
                    <td><span class="uk-label uk-label-warning">In Progress</span></td>
                    <td><button class="uk-button uk-button-primary">View Details</button></td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Agent Conversations Section -->
        <div class="uk-card uk-card-default uk-card-body uk-margin-medium-bottom">
            <h3 class="uk-card-title">Agent Conversations</h3>
            <ul class="uk-comment-list">
                <li>
                    <article class="uk-comment">
                        <header class="uk-comment-header">
                            <h4 class="uk-comment-title">Agent</h4>
                        </header>
                        <div class="uk-comment-body">
                            <p>Converted module A from Python to PHP.</p>
                        </div>
                    </article>
                </li>
                <li>
                    <article class="uk-comment">
                        <header class="uk-comment-header">
                            <h4 class="uk-comment-title">Agent</h4>
                        </header>
                        <div class="uk-comment-body">
                            <p>Adjusted the use of async functions to match PHP's concurrency model.</p>
                        </div>
                    </article>
                </li>
            </ul>
        </div>

        <!-- Activity Log Section -->
        <div class="uk-card uk-card-default uk-card-body uk-margin-medium-bottom">
            <h3 class="uk-card-title">Activity Log</h3>
            <ul class="uk-list uk-list-divider">
                <li>2024-09-23 10:00 AM: Agent completed conversion of `utils.py` to `Utils.php`.</li>
                <li>2024-09-23 11:00 AM: User added a manual task to review architecture changes.</li>
            </ul>
        </div>

        <!-- Actions & Next Steps Section -->
        <div class="uk-card uk-card-default uk-card-body uk-margin-medium-bottom">
            <h3 class="uk-card-title">Actions & Next Steps</h3>
            <div class="uk-button-group">
                <button class="uk-button uk-button-primary">Advance Workflow</button>
                <button class="uk-button uk-button-secondary">Add New Task</button>
                <button class="uk-button uk-button-warning">Send Feedback</button>
                <button class="uk-button uk-button-danger">Archive Goal</button>
            </div>
        </div>

    </div>


</x-panel-layout>

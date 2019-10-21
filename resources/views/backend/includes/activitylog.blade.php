<div class="accordion" id="activityLogBlock">
    <div class="card card-accent-primary">
        <div class="card-header" id="activityLog">
            <button class="btn btn-outline-primary collapsed" type="button" data-toggle="collapse" data-target="#activityLogSection" aria-expanded="false" aria-controls="activityLogSection">
                Show Activity Log
            </button>
        </div>
        <div id="activityLogSection" class="collapse" aria-labelledby="activityLog" data-parent="#activityLogBlock">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <h4>Activity Log</h4>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            Current
                                        </th>
                                        <th class="text-center">
                                            Old
                                        </th>
                                        <th>
                                            At
                                        </th>
                                        <th>
                                            User
                                        </th>
                                        <th>
                                            Type
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activities as $activity)
                                    <tr>
                                        <td>
                                            <?php $attributes = $activity->properties['attributes']; ?>
                                            <ul class="list-unstyled">
                                                @foreach ($attributes as $key => $value)
                                                <li>
                                                    <i class="fas fa-angle-right"></i> <em>{{label_case($key)}}</em>: <mark>{{$value}}</mark>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            @if (isset($activity->properties['old']))
                                            <?php $attributes = $activity->properties['old']; ?>
                                            <ul class="list-unstyled">
                                                @foreach ($attributes as $key => $value)
                                                <li>
                                                    <i class="fas fa-angle-right"></i> <em>{{label_case($key)}}</em>: <mark>{{$value}}</mark>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </td>
                                        <td>
                                            Updated: {{$activity->updated_at->diffForHumans()}}<br>
                                            At: {{$activity->updated_at->toDayDateTimeString()}}
                                        </td>
                                        <td>
                                            {{ label_case($activity->causer_id) }}
                                        </td>
                                        <td>
                                            {{ label_case($activity->description) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{$activities->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

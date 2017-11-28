@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.5.2/animate.min.css">
@stop

<title>{{ $pr_tracker->no }}</title>

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-compass"></i>
        {{ $pr_tracker->no }}
    </h1>
@stop

@section('content')
    <div id="vue_app" class="page-content container-fluid edit-add">

        <!-- TRACKER INFO -->
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="voyager-info-circled"></i>
                        TRACKER INFO
                    </h3>
                    <div class="panel-actions">
						<a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
					</div>
                </div>
                <div class="panel-body">
                    <form action="">
                        <table class="table table-hover table-responsive">
                            <tbody>
                                <tr>
                                    <td><i class="voyager-character">&nbsp;</i><b>TITLE:</b></td>
                                    <td v-on:mouseOver="hovered_tracker_title = true" v-on:mouseLeave="hovered_tracker_title = false">
                                        <template v-if="tracker_title_edit_mode">
                                            <input type="text" class="form-control" v-model="pr_tracker.title">
                                        </template>
                                        <template v-else>
                                            @{{ pr_tracker.title }}
                                            <button v-on:click.prevent="tracker_title_edit_mode = true" v-show="hovered_tracker_title" class="btn btn-default pull-right"><i class="voyager-pen"></i></button>
                                        </template>
                                    </td>
                                </tr>
                                <tr>
                                <tr>
                                    <td><i class="voyager-person"></i>&nbsp;<b>PROPONENT:</b></td>
                                    <td v-on:mouseOver="hovered_tracker_proponent = true" v-on:mouseLeave="hovered_tracker_proponent = false">
                                    <template v-if="tracker_proponent_edit_mode">
                                        <input type="text" class="form-control" v-model="pr_tracker.proponent">
                                    </template>
                                    <template v-else>
                                        @{{ pr_tracker.proponent }}
                                        <button v-on:click.prevent="tracker_proponent_edit_mode = true" v-show="hovered_tracker_proponent" class="btn btn-default pull-right"><i class="voyager-pen"></i></button>
                                    </template>
                                </td>
                                </tr>
                                <tr>
                                    <td><i class="voyager-calendar"></i>&nbsp;<b>DATE CREATED:</b></td>
                                    <td>@{{ pr_tracker.created_at }}</td>
                                </tr>
                                <td><i class="voyager-watch"></i>&nbsp;<b>LAST UPDATED:</b></td>
                                    <td>@{{ pr_tracker.updated_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <button v-if="(tracker_title_edit_mode || tracker_proponent_edit_mode)" v-on:click.prevent="update_pr_tracker()" class="btn btn-warning pull-right">
                            <i class="voyager-pen"></i>
                            UPDATE
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Request Panel -->
        <div class="col-md-5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="voyager-list-add"></i>
                        Create New @{{ (isSupplemental) ? 'Supplemental Request' : 'Purchase Request' }}
                    </h3>
                </div>
                <div class="panel-body">

                    <form class="form" action="">

                        <!-- Request Type Selection -->
                        <div class="form-group">
                            <div class="btn-group" role="group" aria-label="...">
                                <button v-on:click="isSupplemental = false" type="button" class="btn btn-default">
                                    <transition
                                        enter-active-class="animated fadeIn"
                                        leave-active-class="animated fadeOut"
                                    >
                                        <i v-if="!isSupplemental" style="color:green;" class="voyager-check-circle"></i> 
                                    </transition>
                                    PR from PPMP
                                </button>
                                <button v-on:click="isSupplemental = true" type="button" class="btn btn-default">
                                    <transition
                                        enter-active-class="animated fadeIn"
                                        leave-active-class="animated fadeOut"
                                    >
                                        <i v-if="isSupplemental" style="color:green;" class="voyager-check-circle"></i> 
                                    </transition>
                                    Supplemental PPMP
                                </button>
                            </div>
                        </div>
                        
                        <!-- Purpose -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="voyager-news"></i></span>
                                <textarea v-model="request.purpose" class="form-control" name="pr_purpose" rows="5" placeholder="Purpose"></textarea>
                            </div>
                        </div>

                        <!-- Proposed Amount -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="voyager-dollar"></i></span>
                                <input v-model="request.proposed_amount" class="form-control" type="number" placeholder="Proposed Amount" name="pr_proposed_amount">
                            </div>
                        </div>

                        <!-- Proposed Date -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="voyager-calendar"></i></span>
                                <input v-model="request.proposed_date" class="form-control" type="text" placeholder="Proposed Date" name="pr_proposed_date">
                            </div>
                        </div>

                        <!-- Proposed Venue -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="voyager-company"></i></span>
                                <input v-model="request.proposed_venue" class="form-control" type="text" placeholder="Proposed Venue" name="pr_proposed_venue">
                            </div>
                        </div>

                        <!-- SUBMIT Buttons -->
                        <div>
                            <button class="btn btn-default" type="button"><i class="voyager-thumbs-up"></i>&nbsp;I already have a PR number</button>
                            <button v-on:click.prevent="submitRequest()" class="btn btn-default" type="button"><i class="voyager-paper-plane"></i>
                                &nbsp;Create @{{ (isSupplemental) ? 'Supplemental Request' : 'Purchase Request' }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <!-- PPMP & SPPMP -->
        <div class="col-md-7">
            <!-- Purchase Request List -->
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="voyager-list"></i>
                        Purchase Request
                    </h3>
                </div>
                <div class="panel-body">

                </div>
            </div>

            <!-- SPPMP List -->
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="voyager-bag"></i>
                        Supplemental Purchase Request
                    </h3>
                </div>
                <div class="panel-body">
                    <template v-if="pr_tracker.supplemental_requests.length > 0">
                        <table class="table table-hover table-responsive">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">#</th>
                                    <th style="text-align:center;">Request ID</th>
                                    <th style="text-align:center;">Purpose</th>
                                    <th style="text-align:center;">Date Created</th>
                                    <th style="text-align:center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody
                                is="transition-group"
                                enter-active-class="animated tada"
                                leave-active-class="animated bounceOutRight"
                            >
                                <tr v-for="(supplemental_request, index) in pr_tracker.supplemental_requests" v-bind:key="supplemental_request.id">
                                    <td>@{{ ++index }}</td>
                                    <td>@{{ supplemental_request.pr_no }}</td>
                                    <td>@{{ supplemental_request.purpose }}</td>
                                    <td>@{{ supplemental_request.created_at }}</td>
                                    <td style="text-align:center;">
                                        <button class="btn btn-warning"><i class="voyager-pen"></i></button>
                                        <button class="btn btn-danger" v-on:click.prevent="delete_pr(--index);"><i class="voyager-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </template>
                </div><!-- panel-body -->
            </div><!-- SPPMP-List -->
        </div><!-- PPMP & SPPMP end -->

        <span class="need_to_be_rendered" datetime="2016-07-07T09:24:17Z">July 07, 2016</span>

    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function(){

            timeago().render($('.need_to_be_rendered'));

            var vue_app = new Vue({
                el: '#vue_app',
                data: {
                    // UI
                    tracker_info_edit_mode: false,
                    tracker_title_edit_mode: false,
                    tracker_proponent_edit_mode: false,

                    hovered_tracker_title: false,
                    hovered_tracker_proponent: false,
                    // UI end

                    pr_tracker: <?php echo $pr_tracker;?>,
                    isSupplemental: false,

                    request: {
                        pr_tracker_id: @php echo $pr_tracker->id; @endphp
                    }
                },
                methods: {
                    submitRequest: function(){
                        var self = this;
                        if(self.isSupplemental){
                            $.ajax({
                                url: "@php echo route('voyager.supplemental-requests.store'); @endphp",
                                method: 'POST',
                                dataType: 'JSON',
                                data: self.request,
                                success: function(stored_supplemental_request){
                                    self.request = {pr_tracker_id: @php echo $pr_tracker->id; @endphp};
                                    self.pr_tracker.supplemental_requests.push(stored_supplemental_request);
                                    toastr.success("Successfully added Supplemental Request.");
                                }
                            });
                        } else{ // request is non-supplemental

                        }
                    },


                    delete_pr: function(supplemental_request_id){
                        var self = this;
                        // TO DO: delete from database.
                        self.pr_tracker.supplemental_requests.splice(supplemental_request_id, 1);
                    },


                    update_pr_tracker: function(){
                        var self = this;
                        $.ajax({
                            url: "@php echo route('voyager.pr-trackers.update', ['pr_tracker' => $pr_tracker->id]); @endphp",
                            method: 'PUT',
                            dataType: 'JSON',
                            data: self.pr_tracker,
                            success: function(updated_pr_tracker){
                                self.pr_tracker.updated_at = updated_pr_tracker.updated_at;

                                self.tracker_proponent_edit_mode = false;
                                self.tracker_title_edit_mode = false;

                                toastr.success("Updated PR Tracker " + updated_pr_tracker.no);
                            }
                        });
                    }
                }
            });
        });
    </script>
@endsection
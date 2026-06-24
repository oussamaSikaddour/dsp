<div class="modal__body__content">

    <div class="form__container">
        <form class="form" wire:submit="handleSubmit">


            <div class="row">
                <x-core.form.selector htmlId="SS-daira" model="dairaId" :label="__('tables.schedule_slots.daira')" :data="$dairatesOptions"
                    type="filter" />
                <x-core.form.selector htmlId="ala-a-location" model="manageForm.appointments_location_id"
                    :label="__('forms.appointments_location_agent.appointments_location_id')" :data="$appointmentsLocationsOptions" />

            </div>
            <div class="row">
                <x-core.form.selector htmlId="ala-mf-id" model="manageForm.user_id" :label="__('forms.appointments_location_agent.user_id')" :data="$personalOptions"
                    :showError="true" />
            </div>

            <div class="form__actions">
                <x-core.button type="submit" icon="confirm" variant="primary" :text="__('forms.common.actions.submit')" :wireTargets="['handleSubmit']"
                    expectLoading="true" fullWidth="true" />
            </div>

        </form>
    </div>

    <div class="table__container" x-on:update-appointments-locations-agents-table.window="$wire.$refresh()">

        @if ($this->appointmentsLocationsAgents->isNotEmpty())

            <div class="table__body">
                <table class="table">

                    <thead>
                        <tr>
                            <th>
                                <div>@lang('tables.common.actions')</div>
                            </th>

                            <x-core.table.sortable-th model="appointments_location" :label="__('tables.appointments_locations_agents.location')" :$sortDirection
                                :$sortBy />
                            <x-core.table.sortable-th model="name" :label="__('tables.appointments_locations_agents.name')" :$sortDirection :$sortBy />

                            <x-core.table.sortable-th model="email" :label="__('tables.appointments_locations_agents.email')" :$sortDirection :$sortBy />
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($this->appointmentsLocationsAgents as $agent)
                            <tr wire:key="agent-{{ $agent->id }}">

                                <td>
                                    <x-core.button variant="danger" icon="ban" function="openDetachAppointmentsLocationAgentDialog"
                                        :parameters="[$agent]" rounded=true hasTooltip=true :tooltip="__('toolTips.coordinator.detach.medical_secretary')" />
                                </td>

                                <td>{{ $agent->appointments_location }}</td>
                                <td>{{ $agent->name }}</td>

                                <td>{{ $agent->email }}</td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        @else
            <div class="table__footer">
                <h2>@lang('tables.appointments_locations_agents.not_found')</h2>
            </div>

        @endif

    </div>

</div>

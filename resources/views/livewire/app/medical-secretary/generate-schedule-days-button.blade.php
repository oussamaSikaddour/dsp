<div style="display: {{ !$schedule->locked ? 'block' : 'none' }}" x-on:update-schedule-days-table.window="$wire.$refresh()">
@if (!$schedule->locked)

        <x-core.button
            variant="danger"
            :text="__('toolTips.schedule.manage.generate')"
            icon="confirm"
            :expectLoading="true"
            function="openGenerateScheduleDaysDialog"
            :wireTargets="['generateScheduleDays']"
        />
@endif
</div>

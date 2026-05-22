@php
    $systemUser = $systemUser ?? null;
@endphp

@csrf

<div class="row g-3">

    <div class="col-md-4">
        <label class="form-label">Custom ID</label>

        <input
            type="text"
            class="form-control"
            value="{{ old('custom_id', $systemUser?->custom_id ?? 'Auto generated') }}"
            readonly>
    </div>

    <div class="col-md-4">
        <label class="form-label">Full Name <span class="text-danger">*</span></label>
        <input
            type="text"
            name="full_name"
            class="form-control @error('full_name') is-invalid @enderror"
            value="{{ old('full_name', $systemUser?->full_name ?? '') }}"
            required>

        @error('full_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Mobile <span class="text-danger">*</span></label>
        <input
            type="text"
            name="mobile"
            class="form-control @error('mobile') is-invalid @enderror"
            value="{{ old('mobile', $systemUser?->mobile ?? '') }}"
            required>

        @error('mobile')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">NIC <span class="text-danger">*</span></label>
        <input
            type="text"
            name="nic"
            class="form-control @error('nic') is-invalid @enderror"
            value="{{ old('nic', $systemUser?->nic ?? '') }}"
            required>

        @error('nic')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Birthday</label>
        <input
            type="date"
            name="bday"
            class="form-control @error('bday') is-invalid @enderror"
            value="{{ old('bday', $systemUser?->bday?->format('Y-m-d') ?? '') }}">

        @error('bday')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Gender <span class="text-danger">*</span></label>

        <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
            <option value="">Select Gender</option>
            <option value="male" @selected(old('gender', $systemUser?->gender ?? '') === 'male')>Male</option>
            <option value="female" @selected(old('gender', $systemUser?->gender ?? '') === 'female')>Female</option>
            <option value="other" @selected(old('gender', $systemUser?->gender ?? '') === 'other')>Other</option>
        </select>

        @error('gender')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Address 1 <span class="text-danger">*</span></label>
        <input
            type="text"
            name="address1"
            class="form-control @error('address1') is-invalid @enderror"
            value="{{ old('address1', $systemUser?->address1 ?? '') }}"
            required>

        @error('address1')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Address 2</label>
        <input
            type="text"
            name="address2"
            class="form-control @error('address2') is-invalid @enderror"
            value="{{ old('address2', $systemUser?->address2 ?? '') }}">

        @error('address2')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Address 3</label>
        <input
            type="text"
            name="address3"
            class="form-control @error('address3') is-invalid @enderror"
            value="{{ old('address3', $systemUser?->address3 ?? '') }}">

        @error('address3')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Email <span class="text-danger">*</span></label>
        <input
            type="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $systemUser?->user?->email ?? '') }}"
            required>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">
            Password
            @if(isset($systemUser))
                <small class="text-muted">(leave blank to keep current password)</small>
            @endif
        </label>
        <input
            type="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            {{ isset($systemUser) ? '' : 'required' }}>

        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Note</label>
        <textarea
            name="note"
            rows="3"
            class="form-control @error('note') is-invalid @enderror">{{ old('note', $systemUser?->note ?? '') }}</textarea>

        @error('note')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <div class="form-check mt-2">
            <input
                type="checkbox"
                name="is_active"
                value="1"
                class="form-check-input"
                id="is_active"
                @checked(old('is_active', $systemUser?->is_active ?? true))>

            <label for="is_active" class="form-check-label">
                Active
            </label>
        </div>
    </div>

</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        Save
    </button>

    <a href="{{ route('admin.system-users.index') }}" class="btn btn-secondary">
        Cancel
    </a>
</div>
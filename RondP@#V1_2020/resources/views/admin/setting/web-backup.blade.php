<div class="tab-pane fade" id="web-backup" role="tabpanel" aria-labelledby="web-backup-tab">
    <div class="form-group">
        <label>{{ __('Export') }}</label>
        <div>
            <button type="button" id="btn-export" class="btn btn-info">
                <i class="fas fa-file-excel"></i> {{ __('Download Export File Data') }}
            </button>
            <button type="button" id="btn-export-storage" class="btn btn-info">
                <i class="fas fa-download"></i> {{ __('Download Backup Storage') }}
            </button>
        </div>
    </div>
    <hr>
    <form action="{{ route('import') }}" method="POST" role="form" enctype="multipart/form-data">
        @method('GET')
        @csrf
        <div class="form-group">
            <label for="">{{ __('Import File Data') }}</label><br>
            <div class="input-group">
                <div class="custom-file">
                    <input id="InputFileBackup" type="file" name="import" class="custom-file-input" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                    <label class="custom-file-label">{{ __('Choose file') }}</label>
                </div>
            </div>
            <p>
                <small>
                    {{ __('Browse file File format must be in the format xlsx') }}<br>
                </small>
            </p>
        </div>
        <button id="uploadFileBackup" type="submit" class="btn btn-info" disabled>
            {{ __('Upload') }}
        </button>
    </form>
</div>

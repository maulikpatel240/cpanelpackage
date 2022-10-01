<!-- Modal -->
@php
    $options = array_merge([
        'class' => 'fade',
        'role' => 'dialog',
        'tabindex' => -1,
        'aria-hidden' => 'true',
        'id' => 'bsmodal'
    ], $modal['options']);

    $size = (isset($modal['size'])) ? $modal['size'] : '';
    $dialogOptions = isset($modal['dialogOptions']) ? array_merge([], $modal['dialogOptions']) : [];
    $dialogOptionsClass = (isset($dialogOptions['class'])) ? 'id='.$dialogOptions['class'] : '';
    $dialogOptionsId = (isset($dialogOptions['id'])) ? 'id='.$dialogOptions['id'] : '';

    $header = isset($modal['header']) ? $modal['header'] : true;
    $headerOptions = isset($modal['headerOptions']) ? array_merge([], $modal['headerOptions']) : [];
    $headerOptionsClass = (isset($headerOptions['class'])) ? 'id='.$headerOptions['class'] : '';
    $headerOptionsId = (isset($headerOptions['id'])) ? 'id='.$headerOptions['id'] : '';

    $bodyOptions = isset($modal['bodyOptions']) ? array_merge([], $modal['bodyOptions']) : [];
    $bodyOptionsClass = (isset($bodyOptions['class'])) ? 'id='.$bodyOptions['class'] : '';
    $bodyOptionsId = (isset($bodyOptions['id'])) ? 'id='.$bodyOptions['id'] : '';

    $titleOptions = isset($modal['titleOptions']) ? array_merge([], $modal['titleOptions']) : '';
    $titleOptionsClass = (isset($titleOptions['class'])) ? 'id='.$titleOptions['class'] : '';
    $titleOptionsId = (isset($titleOptions['id'])) ? $titleOptions['id'] : $options['id'].'-label';

    $closeButton = isset($modal['closeButton']) ? $modal['closeButton'] : true;
    if ($closeButton !== false) {
        if(is_array($closeButton)){
            $closeButton = array_merge([
                'data-bs-dismiss' => 'modal',
                'class' => 'btn-close',
                'type' => 'button',
                'aria-label' => 'Close',
                'label' => ''
            ], $closeButton);
        }else{
            $closeButton = [
                'data-bs-dismiss' => 'modal',
                'class' => 'btn-close',
                'type' => 'button',
                'aria-label' => 'Close',
                'label' => ''
            ];
        }
    }

    $clientOptions = '';
    if (isset($modal['clientOptions']) && $modal['clientOptions'] !== false) {
        $clientOptions = array_merge(['show' => false], $modal['clientOptions']);
    }
    $data_bs_backdrop = (isset($clientOptions['backdrop']) && $clientOptions['backdrop']) ? 'data-bs-backdrop="static"' : '';
    $data_bs_keyboard = (isset($clientOptions['keyboard']) && $clientOptions['keyboard']) ? 'data-bs-keyboard=false' : '';
@endphp
<div class="modal {!! $options['class'] !!}" id="{!! $options['id'] !!}" {!! $data_bs_backdrop !!} {!! $data_bs_keyboard !!} tabindex="{!! $options['tabindex'] !!}" aria-labelledby="{!! $options['id'] !!}-label" aria-hidden="{!! $options['aria-hidden'] !!}">
    <div class="modal-dialog {!! $size !!} {!! $dialogOptionsClass !!}" {!! $dialogOptionsId !!}>
      <div class="modal-content">
          @if($header)
            <div class="modal-header {!! $headerOptionsClass !!}" {!! $headerOptionsId !!}>
                {!! ($modal['title']) ? '<h5 class="modal-title '.$titleOptionsClass.'" id="'.$titleOptionsId.'">'.$modal['title'].'</h5>' : '' !!}
                @if($closeButton)
                <button type="{!! $closeButton['type'] !!}" class="{!! $closeButton['class'] !!}" data-bs-dismiss="{!! $closeButton['data-bs-dismiss'] !!}" aria-label="{!! $closeButton['aria-label'] !!}"></button>
                @endif
            </div>
          @endif
        <div class="modal-body {!! $bodyOptionsClass !!}" {!! $bodyOptionsId !!}>

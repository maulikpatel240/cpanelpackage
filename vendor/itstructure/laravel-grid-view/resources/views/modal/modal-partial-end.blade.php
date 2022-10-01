            @php
                $footer = isset($modal['footer']) ? $modal['footer'] : false;
                $footerContent = isset($modal['footer']['content']) ? $modal['footer']['content'] : '';
                $footerOptions = isset($modal['footerOptions']) ? array_merge([], $modal['footerOptions']) : [];
                $footerOptionsClass = (isset($footerOptions['class'])) ? 'id='.$footerOptions['class'] : '';
                $footerOptionsId = (isset($footerOptions['id'])) ? 'id='.$footerOptions['id'] : '';

                $closeButtonFooter = isset($modal['closeButtonFooter']) ? $modal['closeButtonFooter'] : false;
                if ($closeButtonFooter !== false) {
                    if(is_array($closeButtonFooter)){
                        $closeButtonFooter = array_merge([
                            'data-bs-dismiss' => 'modal',
                            'class' => 'btn btn-secondary',
                            'type' => 'button',
                            'label' => 'Close'
                        ], $closeButtonFooter);
                    }else{
                        $closeButtonFooter = [
                            'data-bs-dismiss' => 'modal',
                            'class' => 'btn btn-secondary',
                            'type' => 'button',
                            'label' => 'Close'
                        ];
                    }

                }
                $submitButton = isset($modal['submitButton']) ? $modal['submitButton'] : false;
                if ($submitButton !== false) {
                    if(is_array($submitButton)){
                        $submitButton = array_merge([
                            'class' => 'btn btn-primary',
                            'id' => 'btn-submit',
                            'type' => 'submit',
                            'label' => 'Save'
                        ], $submitButton);
                    }else{
                        $submitButton = [
                            'class' => 'btn btn-primary',
                            'id' => 'btn-submit',
                            'type' => 'submit',
                            'label' => 'Save'
                        ];
                    }

                }

            @endphp
            </div>
            @if($footer)
            <div class="modal-footer {!! $footerOptionsClass !!}" {!! $footerOptionsId !!}>
                @if($footerContent)
                    {!! $footerContent !!}
                @endif
                @if($closeButtonFooter)
                    <button type="{!! $closeButtonFooter['type'] !!}" class="{!! $closeButtonFooter['class'] !!}" data-bs-dismiss="{!! $closeButtonFooter['data-bs-dismiss'] !!}">{!! $closeButtonFooter['label'] !!}</button>
                @endif
                @if($submitButton)
                    <button type="{!! $submitButton['type'] !!}" class="{!! $submitButton['class'] !!}" id="{!! $submitButton['id'] !!}">{!! $submitButton['label'] !!}</button>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

@props(['contact', 'settings'])

<section class="vb-section" id="contact">
    <div class="vb-container">
        <div class="vb-section__header" data-reveal>
            <span class="vb-section__overline vb-overline">Contact</span>
            <h2 class="vb-section__title vb-h1">Get In Touch</h2>
            <div class="vb-section__divider"></div>
        </div>

        <div class="vb-contact__grid">
            <div class="vb-contact__info" data-reveal="left">
                <h3 class="vb-h3" style="margin-bottom: var(--space-xl);">Let's Work Together</h3>

                @if($contact)
                    @if($contact->email)
                        <div class="vb-contact__item">
                            <div class="vb-contact__item-icon">✉</div>
                            <div>
                                <div class="vb-contact__item-label">Email</div>
                                <div class="vb-contact__item-value">{{ $contact->email }}</div>
                            </div>
                        </div>
                    @endif
                    @if($contact->phone)
                        <div class="vb-contact__item">
                            <div class="vb-contact__item-icon">☎</div>
                            <div>
                                <div class="vb-contact__item-label">Phone</div>
                                <div class="vb-contact__item-value">{{ $contact->phone }}</div>
                            </div>
                        </div>
                    @endif
                    @if($contact->address)
                        <div class="vb-contact__item">
                            <div class="vb-contact__item-icon">◉</div>
                            <div>
                                <div class="vb-contact__item-label">Location</div>
                                <div class="vb-contact__item-value">{{ $contact->address }}{{ $contact->city ? ', ' . $contact->city : '' }}{{ $contact->country ? ', ' . $contact->country : '' }}</div>
                            </div>
                        </div>
                    @endif
                @endif

                @if($settings['site_email'])
                    <div class="vb-contact__item">
                        <div class="vb-contact__item-icon">✉</div>
                        <div>
                            <div class="vb-contact__item-label">General</div>
                            <div class="vb-contact__item-value">{{ $settings['site_email'] }}</div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="vb-contact__form-wrap" data-reveal="right">
                <form id="contactForm" action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="vb-form__group">
                        <label class="vb-form__label" for="name">Name</label>
                        <input class="vb-form__input" type="text" id="name" name="name" required placeholder="Your name">
                    </div>
                    <div class="vb-form__group">
                        <label class="vb-form__label" for="email">Email</label>
                        <input class="vb-form__input" type="email" id="email" name="email" required placeholder="your@email.com">
                    </div>
                    <div class="vb-form__group">
                        <label class="vb-form__label" for="subject">Subject</label>
                        <input class="vb-form__input" type="text" id="subject" name="subject" required placeholder="Project inquiry">
                    </div>
                    <div class="vb-form__group">
                        <label class="vb-form__label" for="message">Message</label>
                        <textarea class="vb-form__textarea" id="message" name="message" required placeholder="Tell me about your project..."></textarea>
                    </div>
                    <button type="submit" class="vb-btn vb-btn--primary magnetic" data-cursor>Send Message →</button>
                </form>
            </div>
        </div>
    </div>
</section>

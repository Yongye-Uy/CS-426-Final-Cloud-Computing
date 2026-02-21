<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Frequently Asked Questions</h2>
            <p class="lead text-muted">Find answers to common questions about {{ config('app.name', 'Donation Tracker') }}</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                Is {{ config('app.name') }} secure for processing donations?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, {{ config('app.name') }} uses bank-level 256-bit SSL encryption and is PCI DSS compliant. We never store full credit card numbers on our servers and partner with trusted payment processors to ensure your donors' information is always secure.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                Can I import data from my current system?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Absolutely. {{ config('app.name') }} supports CSV imports for donors, donations, and other data. We also offer dedicated migration assistance for larger imports from common systems like Raiser's Edge, DonorPerfect, and Salesforce. Our support team can help ensure a smooth transition.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                How does the free trial work?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Our free trial gives you full access to all Professional plan features for 14 days, no credit card required. You can add up to 100 test donations during this period to evaluate the system. At the end of the trial, you can choose a plan or export your data if you decide not to continue.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                Do you offer discounts for nonprofits?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, registered 501(c)(3) organizations qualify for a 15% discount on all plans. Educational institutions and places of worship may also qualify for special pricing. Contact our sales team with proof of your nonprofit status to receive your discount code.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 shadow-sm">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                What payment methods do you support?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {{ config('app.name') }} integrates with all major payment processors including Stripe, PayPal, Authorize.Net, and more. This allows you to accept credit/debit cards, ACH bank transfers, Apple Pay, Google Pay, and in some cases, cryptocurrency donations. You can also record cash and check donations manually.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
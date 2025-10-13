class PriceTicker {
    constructor() {
        this.apiToken = 'bo2fmBJhQlBEww7XaJ1EKaqeijnKpbM53R4Xl_Ufd_c=';
        this.baseUrl = 'https://api.nerkh.io/v1/prices';
        this.tickerElement = document.getElementById('ticker');
        this.previousPrices = {}; // Store previous prices for trend calculation
        
        // Initialize the ticker
        this.init();
    }

    async init() {
        try {
            // Fetch all price data using optimized single request
            const allPrices = await this.fetchAllPrices();
            
            if (allPrices) {
                const { currencyData, goldData, cryptoData } = allPrices;
                // Update the ticker with real data
                this.updateTicker(currencyData, goldData, cryptoData);
            }
            
            // Set up periodic updates (every 30 seconds)
            setInterval(() => {
                this.updatePrices();
            }, 30000);
            
        } catch (error) {
            console.error('خطا در بارگذاری قیمت‌ها:', error);
        }
    }

    async fetchCurrencyPrices() {
        try {
            const response = await fetch(`${this.baseUrl}/xml/currency`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.apiToken}`
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const xmlText = await response.text();
            return this.parseXMLCurrency(xmlText);
        } catch (error) {
            console.error('خطا در دریافت قیمت ارز:', error);
            return null;
        }
    }

    async fetchGoldPrices() {
        try {
            const response = await fetch(`${this.baseUrl}/xml/gold`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.apiToken}`
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const xmlText = await response.text();
            return this.parseXMLGold(xmlText);
        } catch (error) {
            console.error('خطا در دریافت قیمت طلا:', error);
            return null;
        }
    }

    async fetchCryptoPrices() {
        try {
            const response = await fetch(`${this.baseUrl}/xml/crypto`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.apiToken}`
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const xmlText = await response.text();
            return this.parseXMLCrypto(xmlText);
        } catch (error) {
            console.error('خطا در دریافت قیمت رمزارز:', error);
            return null;
        }
    }

    // Optimized method to fetch all prices in a single request
    async fetchAllPrices() {
        try {
            // Use Promise.all to fetch all data simultaneously for better performance
            const [currencyResponse, goldResponse, cryptoResponse] = await Promise.all([
                fetch(`${this.baseUrl}/xml/currency`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${this.apiToken}`
                    }
                }),
                fetch(`${this.baseUrl}/xml/gold`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${this.apiToken}`
                    }
                }),
                fetch(`${this.baseUrl}/xml/crypto`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${this.apiToken}`
                    }
                })
            ]);

            // Check if all responses are successful
            if (!currencyResponse.ok || !goldResponse.ok || !cryptoResponse.ok) {
                throw new Error('One or more API requests failed');
            }

            // Parse all responses simultaneously
            const [currencyXML, goldXML, cryptoXML] = await Promise.all([
                currencyResponse.text(),
                goldResponse.text(),
                cryptoResponse.text()
            ]);

            // Parse all XML data simultaneously
            const [currencyData, goldData, cryptoData] = await Promise.all([
                Promise.resolve(this.parseXMLCurrency(currencyXML)),
                Promise.resolve(this.parseXMLGold(goldXML)),
                Promise.resolve(this.parseXMLCrypto(cryptoXML))
            ]);

            return { currencyData, goldData, cryptoData };
        } catch (error) {
            console.error('خطا در دریافت همه قیمت‌ها:', error);
            return null;
        }
    }

    parseXMLCurrency(xmlText) {
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(xmlText, 'text/xml');
        const currencies = {};

        const currencyElements = xmlDoc.getElementsByTagName('currency');
        for (let currency of currencyElements) {
            const symbol = currency.getAttribute('symbol');
            const current = currency.getElementsByTagName('current')[0]?.textContent;
            
            if (symbol && current) {
                currencies[symbol] = parseInt(current);
            }
        }

        return currencies;
    }

    parseXMLGold(xmlText) {
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(xmlText, 'text/xml');
        const gold = {};

        const goldElements = xmlDoc.getElementsByTagName('gold');
        for (let goldItem of goldElements) {
            const symbol = goldItem.getAttribute('symbol');
            const current = goldItem.getElementsByTagName('current')[0]?.textContent;
            
            if (symbol && current) {
                gold[symbol] = parseInt(current);
            }
        }

        return gold;
    }

    parseXMLCrypto(xmlText) {
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(xmlText, 'text/xml');
        const crypto = {};

        const cryptoElements = xmlDoc.getElementsByTagName('crypto');
        for (let cryptoItem of cryptoElements) {
            const symbol = cryptoItem.getAttribute('symbol');
            const current = cryptoItem.getElementsByTagName('current')[0]?.textContent;
            
            if (symbol && current) {
                crypto[symbol] = parseInt(current);
            }
        }

        return crypto;
    }

    formatPrice(price, type = 'currency') {
        const numPrice = parseFloat(price);
        
        if (type === 'crypto' && numPrice > 1000000) {
            // For large crypto prices, show in millions
            return new Intl.NumberFormat('fa-IR', {
                maximumFractionDigits: 1
            }).format(numPrice / 1000000) + ' میلیون';
        } else if (type === 'gold' && numPrice > 1000000) {
            // For gold prices, show in millions
            return new Intl.NumberFormat('fa-IR', {
                maximumFractionDigits: 1
            }).format(numPrice / 1000000) + ' میلیون';
        } else if (numPrice < 1000) {
            // For small prices, show with 2 decimal places
            return new Intl.NumberFormat('fa-IR', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            }).format(numPrice);
        } else {
            // For regular prices, show without decimals
            return new Intl.NumberFormat('fa-IR', {
                maximumFractionDigits: 0
            }).format(numPrice);
        }
    }

    // Calculate price trend by comparing with previous price
    getPriceTrend(symbol, currentPrice) {
        if (!this.previousPrices[symbol]) {
            return 'up'; // Default to up for first load
        }
        
        const previousPrice = this.previousPrices[symbol];
        return currentPrice > previousPrice ? 'up' : 'down';
    }

    getSVGIcon(type, trend = 'up') {
        const upIcon = `<svg width="9" height="11" viewBox="0 0 9 11" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.16044 4.0379C0.885724 4.29825 0.874081 4.73201 1.13443 5.00672C1.39479 5.28144 1.82855 5.29308 2.10326 5.03273L1.63185 4.53531L1.16044 4.0379ZM5.15715 2.1385C5.43187 1.87815 5.44351 1.44439 5.18316 1.16967C4.92281 0.894955 4.48905 0.883312 4.21433 1.14367L4.68574 1.64108L5.15715 2.1385ZM5.15714 1.14356C4.88243 0.883202 4.44867 0.894845 4.18831 1.16956C3.92796 1.44428 3.9396 1.87804 4.21432 2.13839L4.68573 1.64097L5.15714 1.14356ZM7.26821 5.03262C7.54293 5.29297 7.97669 5.28133 8.23704 5.00661C8.49739 4.7319 8.48575 4.29814 8.21104 4.03779L7.73962 4.5352L7.26821 5.03262ZM5.37103 1.64108C5.37103 1.26259 5.06421 0.95577 4.68572 0.95577C4.30724 0.95577 4.00041 1.26259 4.00041 1.64108H4.68572H5.37103ZM4.00041 9.35903C4.00041 9.73752 4.30724 10.0443 4.68572 10.0443C5.06421 10.0443 5.37103 9.73752 5.37103 9.35903H4.68572H4.00041ZM1.63185 4.53531L2.10326 5.03273L5.15715 2.1385L4.68574 1.64108L4.21433 1.14367L1.16044 4.0379L1.63185 4.53531ZM4.68573 1.64097L4.21432 2.13839L7.26821 5.03262L7.73962 4.5352L8.21104 4.03779L5.15714 1.14356L4.68573 1.64097ZM4.68572 1.64108H4.00041V9.35903H4.68572H5.37103V1.64108H4.68572Z" fill="#1AAB03" />
        </svg>`;
        
        const downIcon = `<svg width="8" height="10" viewBox="0 0 8 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.30732 6.45374C7.58185 6.19319 7.59318 5.75943 7.33262 5.4849C7.07207 5.21037 6.63831 5.19904 6.36378 5.45959L6.83555 5.95667L7.30732 6.45374ZM3.33983 8.32959C3.0653 8.59014 3.05397 9.02391 3.31452 9.29844C3.57507 9.57297 4.00884 9.5843 4.28337 9.32374L3.8116 8.82667L3.33983 8.32959ZM3.33978 9.32374C3.61431 9.5843 4.04807 9.57297 4.30863 9.29844C4.56918 9.02391 4.55785 8.59014 4.28332 8.32959L3.81155 8.82667L3.33978 9.32374ZM1.25937 5.45959C0.98484 5.19904 0.551072 5.21037 0.290521 5.4849C0.0299697 5.75943 0.0412998 6.19319 0.315828 6.45374L0.787598 5.95667L1.25937 5.45959ZM3.12623 8.82667C3.12623 9.20515 3.43305 9.51198 3.81154 9.51198C4.19003 9.51198 4.49685 9.20515 4.49685 8.82667H3.81154H3.12623ZM4.49685 1.17333C4.49685 0.794847 4.19003 0.488023 3.81154 0.488023C3.43305 0.488023 3.12623 0.794847 3.12623 1.17333H3.81154H4.49685ZM6.83555 5.95667L6.36378 5.45959L3.33983 8.32959L3.8116 8.82667L4.28337 9.32374L7.30732 6.45374L6.83555 5.95667ZM3.81155 8.82667L4.28332 8.32959L1.25937 5.45959L0.787598 5.95667L0.315828 6.45374L3.33978 9.32374L3.81155 8.82667ZM3.81154 8.82667H4.49685V1.17333H3.81154H3.12623L3.12623 8.82667H3.81154Z" fill="#F82D2D" />
        </svg>`;

        return trend === 'up' ? upIcon : downIcon;
    }

    updateTicker(currencyData, goldData, cryptoData) {
        if (!this.tickerElement) return;

        let tickerHTML = '';
        const currentPrices = {}; // Store current prices for trend calculation

        // Add gold prices
        if (goldData) {
            if (goldData['SEKE_EMAMI']) {
                const price = goldData['SEKE_EMAMI'];
                const trend = this.getPriceTrend('SEKE_EMAMI', price);
                currentPrices['SEKE_EMAMI'] = price;
                tickerHTML += `<span class="flex flex-row-reverse items-center gap-2">
                    <span>${this.getSVGIcon('gold', trend)}</span>سکه امامی (۲۴ عیار) ${this.formatPrice(price, 'gold')} تومان
                </span>`;
            }
            if (goldData['GOLD18K']) {
                const price = goldData['GOLD18K'];
                const trend = this.getPriceTrend('GOLD18K', price);
                currentPrices['GOLD18K'] = price;
                tickerHTML += `<span class="flex flex-row-reverse items-center gap-2">
                    <span>${this.getSVGIcon('gold', trend)}</span>طلا ۱۸ عیار ${this.formatPrice(price, 'gold')} تومان
                </span>`;
            }
            if (goldData['MAZANEH']) {
                const price = goldData['MAZANEH'];
                const trend = this.getPriceTrend('MAZANEH', price);
                currentPrices['MAZANEH'] = price;
                tickerHTML += `<span class="flex flex-row-reverse items-center gap-2">
                    <span>${this.getSVGIcon('gold', trend)}</span>مظنه ${this.formatPrice(price, 'gold')} تومان
                </span>`;
            }
            if (goldData['OUNCE']) {
                const price = goldData['OUNCE'];
                const trend = this.getPriceTrend('OUNCE', price);
                currentPrices['OUNCE'] = price;
                tickerHTML += `<span class="flex flex-row-reverse items-center gap-2">
                    <span>${this.getSVGIcon('gold', trend)}</span>انس جهانی ${this.formatPrice(price, 'gold')} تومان
                </span>`;
            }
        }

        // Add currency prices
        if (currencyData) {
            if (currencyData['USD']) {
                const price = currencyData['USD'];
                const trend = this.getPriceTrend('USD', price);
                currentPrices['USD'] = price;
                tickerHTML += `<span class="flex flex-row-reverse items-center gap-2">
                    <span>${this.getSVGIcon('currency', trend)}</span>دلار ${this.formatPrice(price)} تومان
                </span>`;
            }
            if (currencyData['EUR']) {
                const price = currencyData['EUR'];
                const trend = this.getPriceTrend('EUR', price);
                currentPrices['EUR'] = price;
                tickerHTML += `<span class="flex flex-row-reverse items-center gap-2">
                    <span>${this.getSVGIcon('currency', trend)}</span>یورو ${this.formatPrice(price)} تومان
                </span>`;
            }
            if (currencyData['GBP']) {
                const price = currencyData['GBP'];
                const trend = this.getPriceTrend('GBP', price);
                currentPrices['GBP'] = price;
                tickerHTML += `<span class="flex flex-row-reverse items-center gap-2">
                    <span>${this.getSVGIcon('currency', trend)}</span>پوند ${this.formatPrice(price)} تومان
                </span>`;
            }
            if (currencyData['TRY']) {
                const price = currencyData['TRY'];
                const trend = this.getPriceTrend('TRY', price);
                currentPrices['TRY'] = price;
                tickerHTML += `<span class="flex flex-row-reverse items-center gap-2">
                    <span>${this.getSVGIcon('currency', trend)}</span>لیر ترکیه ${this.formatPrice(price)} تومان
                </span>`;
            }
            if (currencyData['AED']) {
                const price = currencyData['AED'];
                const trend = this.getPriceTrend('AED', price);
                currentPrices['AED'] = price;
                tickerHTML += `<span class="flex flex-row-reverse items-center gap-2">
                    <span>${this.getSVGIcon('currency', trend)}</span>درهم امارات ${this.formatPrice(price)} تومان
                </span>`;
            }
        }

        // Add crypto prices
        if (cryptoData) {
            if (cryptoData['BTC']) {
                const price = cryptoData['BTC'];
                const trend = this.getPriceTrend('BTC', price);
                currentPrices['BTC'] = price;
                tickerHTML += `<span class="flex flex-row-reverse items-center gap-2">
                    <span>${this.getSVGIcon('crypto', trend)}</span>بیت‌کوین ${this.formatPrice(price, 'crypto')} تومان
                </span>`;
            }
            if (cryptoData['ETH']) {
                const price = cryptoData['ETH'];
                const trend = this.getPriceTrend('ETH', price);
                currentPrices['ETH'] = price;
                tickerHTML += `<span class="flex flex-row-reverse items-center gap-2">
                    <span>${this.getSVGIcon('crypto', trend)}</span>اتریوم ${this.formatPrice(price, 'crypto')} تومان
                </span>`;
            }
            if (cryptoData['USDT']) {
                const price = cryptoData['USDT'];
                const trend = this.getPriceTrend('USDT', price);
                currentPrices['USDT'] = price;
                tickerHTML += `<span class="flex flex-row-reverse items-center gap-2">
                    <span>${this.getSVGIcon('crypto', trend)}</span>تتر ${this.formatPrice(price, 'currency')} تومان
                </span>`;
            }
        }

        // Update previous prices for next comparison
        this.previousPrices = { ...this.previousPrices, ...currentPrices };

        // Duplicate content for infinite loop effect
        const duplicatedHTML = tickerHTML + tickerHTML;
        this.tickerElement.innerHTML = duplicatedHTML;
    }

    async updatePrices() {
        try {
            // Use optimized single request for updates
            const allPrices = await this.fetchAllPrices();
            
            if (allPrices) {
                const { currencyData, goldData, cryptoData } = allPrices;
                this.updateTicker(currencyData, goldData, cryptoData);
            }
        } catch (error) {
            console.error('خطا در به‌روزرسانی قیمت‌ها:', error);
        }
    }
}

// Initialize the price ticker when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new PriceTicker();
});
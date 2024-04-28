"use strict";

// Import Clock
import { clock } from "./_clock";

(function () {
    if (document.body.classList.contains('dashboard')) {
        // Update clock per second
        setInterval(clock, 1000);
    }
})();


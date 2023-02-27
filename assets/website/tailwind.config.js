module.exports = {
    content: ["./src/**/*.{hbs,html,scss}"],
    theme: {
        patterns: {
            opacities: {
                100: "1",
                80: ".80",
                60: ".60",
                40: ".40",
                20: ".20",
                10: ".10",
                5: ".05",
            },
            sizes: {
                1: "0.25rem",
                2: "0.5rem",
                4: "1rem",
                6: "1.5rem",
                8: "2rem",
                16: "4rem",
                20: "5rem",
                24: "6rem",
                32: "8rem",
            },
        },
        screens: {
            xs: "320px",
            // => @media (min-width: 320px) { ... }

            sm: "640px",
            // => @media (min-width: 640px) { ... }

            md: "768px",
            // => @media (min-width: 768px) { ... }

            lg: "1024px",
            // => @media (min-width: 1024px) { ... }

            xl: "1280px",
            // => @media (min-width: 1280px) { ... }

            "2xl": "1440px",
            // => @media (min-width: 1440px) { ... }
        },
        extend: {
            important: true,
            height: {
                header: "9.375rem", //150px
            },
            maxWidth: {
                logo: "15rem",
            },
            padding: {
                "bb-container-lg": "7.5rem", // Desktop
                "bb-container-md": "3rem", // Tablet
                "bb-container-sm": "2rem", // Phone-Phablets
                "bb-container-xs": "1rem", // Small phones
                "nav-lg": "1.1rem", // 19px Desktop;
            },
            colors: {
                blue: {},
                colors: {
                    turqoise: {
                        base: "#53BFBF",
                        dark: "#41A6AC",
                        subtle: "#C1E8E8",
                        opacity: "rgba(193, 232, 232, 0.15);",
                    },
                    red: {
                        base: "#F05F44",
                    },
                },
            },
            boxShadow: {
                "menu-shadow": "0px 4px 4px rgba(0, 0, 0, 0.25)",
                "carousel-nav-shadow": "0px 2px 10px rgba(0, 0, 0, 0.15)",
                "button-focus":
                    "0px 1px 2px rgba(0, 0, 0, 0.05), 0px 0px 0px 2px #FFFFFF, 0px 0px 0px 4px #6366F1",
                "banner-shadow": "0px 2px 10px rgba(0, 0, 0, 0.1)",
            },
            fontFamily: {
                "open-sans-regular": ["OpenSans", "sans-serif"],
                "open-sans-semibold": ["OpenSansSemiBold", "sans-serif"],
                "inter-1": ["Inter-100", "sans-serif"],
                "inter-4": ["Inter-400", "sans-serif"],
                "inter-5": ["Inter-500", "sans-serif"],
                "inter-6": ["Inter-600", "sans-serif"],
                "inter-7": ["Inter-700", "sans-serif"],
                "inter-8": ["Inter-800", "sans-serif"],
                "inter-9": ["Inter-900", "sans-serif"],
            },
            fontSize: {
                base: ["16px", "125%"],
                regular: ["1rem", "1.5rem"],
                medium: ["1.5rem", "1.75rem"],
                medium2: ["1.2rem", "2rem"],
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("tailwindcss-dotted-background"),
        require("tailwindcss-bg-patterns"),
        require('@tailwindcss/typography'),
    ],
};

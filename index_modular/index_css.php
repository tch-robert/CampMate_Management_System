<style>
    :root {
        --aside-width: 250px;
        --header-height: 186px;
    }

    .main-header {
        width: var(--aside-width);
        background: var(--secondary-color);

        .logo,
        .text {
            margin-left: 30px;
            margin-right: 30px;
            margin-top: 20px;
            border-radius: 24px;
        }

        .logo {
            padding: 30px 20px;
            background: #9ba45c;
            box-shadow: 6px 6px 10px #798048,
                -6px -6px 10px #bdc870;

            &:hover {
                box-shadow: inset 6px 6px 10px #798048,
                    inset -6px -6px 10px #bdc870;
            }
        }

        .text {
            margin-bottom: 20px;
            text-align: center;
            padding: 9px;
            font-size: 14px;
            color: var(--primary-color);
            background: #9ba45c;
            box-shadow: inset 6px 6px 10px #798048,
                inset -6px -6px 10px #bdc870;
        }
    }

    .aside-left {
        padding: var(--header-height) 20px 0 20px;
        width: var(--aside-width);
        top: 0;
        overflow: auto;
        background: var(--secondary-color);

        li {
            margin-bottom: 18px;

            a {
                transition: 0.3s ease;
                color: #fff;
                letter-spacing: 1px;

                &:hover {
                    transform: translate(-3px, -3px);

                    i {
                        color: #9ba45c;
                        background: linear-gradient(145deg, #ffefda, #d7c9b8);
                        box-shadow: 2px 2px 8px #baae9f,
                            -2px -2px 8px #fffff9;
                    }
                }
            }

            i {
                width: 48px;
                height: 48px;
                text-align: center;
                transition: 0.3s ease;
                padding: 15px;
                margin-right: 10px;
                border-radius: 16px;
                background: linear-gradient(145deg, #a6af62, #8c9453);
                box-shadow: 6px 6px 12px #848b4e,
                    -6px -6px 12px #b2bd6a;
            }

            span {
                font-size: 12px;
            }

            .line {
                margin: 0 16px;
                border: none;
                height: 1px;
                background: var(--primary-color);
            }
        }
    }

    .main-content {
        margin-left: var(--aside-width);
        margin-top: 20px;
    }

    .aside-a-active {
        transform: translate(-3px, -3px);
    }

    .aside-i-active {
        color: #9ba45c;
        background: linear-gradient(145deg, #ffefda, #d7c9b8) !important;
        box-shadow: 2px 2px 8px #baae9f,
            -2px -2px 8px #fffff9 !important;
    }
</style>
<style>
    .footer {
        background-color: transparent;
        color: #333; 
        text-align: center;
        padding: 10px 0;
        position: absolute;
        bottom: 0;
        width: 100%;
        overflow: hidden;
    }

    /* animation that moves the text to the left */
    @keyframes runningText {
        0% {
            transform: translateX(100%);
        }
        100% {
            transform: translateX(-100%);
        }
    }

    /* Apply the animation to the text within the footer */
    .footer-text {
        display: inline-block;
        white-space: nowrap; /* Prevent text from wrapping */
        animation: runningText 20s linear infinite; /* duration (20s) as needed */
    }
</style>
</head>
<body>
    
    <!-- Running footer -->
    <div class="footer">
        <span class="footer-text">Mini Ticketing System - All Rights Reserved</span>
    </div>

    <!-- Js-->
    <script src="path/to/bootstrap.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>College Club Management System</title>
    <?php require 'utils/styles.php'; ?><!-- CSS links, file found in utils folder -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        
        .aboutus {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            color: #004d99;
            font-size: 2.5em;
            margin-bottom: 20px;
            text-align: center;
        }

        p {
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 1.1em;
            text-align: justify;
        }

        .blueline {
            border: 5px solid #004d99;
            border-radius: 5px;
            margin: 20px 0;
        }

        iframe {
            width: 100%;
            height: 450px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .aboutus {
                width: 95%;
            }

            h1 {
                font-size: 2em;
            }

            p {
                font-size: 1em;
                text-align: justify;
            }
        }
    </style>
</head>

<body>
    <?php require 'utils/header.php'; ?>
    <hr class="blueline">
    <div class="aboutus">
        <h1><strong>About Us</strong></h1>
        <h2><strong>What is Lorem Ipsum?</strong></h2>
        <p>
          Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
        </p>
        <h2><strong>Why do we use it?</strong></h2>
        <p>
          It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
        </p> 
          <h2><strong>Where does it come from?</strong></h2>
        <p>
          Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
        </p>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3888.068277373038!2d77.71137147484129!3d12.967482787347521!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae130f321b2b95%3A0x74b2c05bbc2aac8d!2sCMR%20Institute%20of%20Technology!5e0!3m2!1sen!2sin!4v1725288175931!5m2!1sen!2sin" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <hr class="blueline">
    <?php require 'utils/footer.php'; ?>
</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating and Review</title>
    <style>
        main{
            font-family: "IBM Plex Sans", sans-serif;   
        }
        
        form {
            padding: 2em;  
        } 
        form > h1 {
            text-align: center;
            font-weight: 600;
            color: #000;
            font-size: 26px;
            /* font-family: "IBM Plex Sans", sans-serif; */
        }
        form > p {
            text-align: center;
            margin-bottom: 1.4em;
            line-height: 1.8;
            font-weight: 400;
            font-size: 16px;
            /* font-family: "IBM Plex Sans", sans-serif; */
        }
        form > .textarea-group {
            margin-top: 1.4em;
        }
        form > .textarea-group > label {
            display: block;
            width: 100%;
        }
        form > .textarea-group > label > span {
            display: block;
            font-size: 0.9em;
            font-weight: 600;
            margin-bottom: 0.8em;
            font-family: "IBM Plex Sans", sans-serif;
        }
        form > .textarea-group > label > textarea {
            box-sizing: border-box;
            display: block;
            padding: 1em;
            font-family: "IBM Plex Sans", sans-serif;
            line-height: 1.8;
            width: 100%;
            resize: none;
            border: 1px solid;
            border-radius: 6px;
            /* background-color: #ebebeb; */
            
        }
        form > div.action-group {
            margin-top: 2em;
            display: flex;
            flex-direction: column;
            row-gap: 1em;
        }
        form > div.action-group > input[type="reset"] {
            padding: 1em 2em;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 0.9em;
            font-weight: 600;
            opacity: 0.8;
            font-family: "IBM Plex Sans", sans-serif;
        }
        @media (hover: hover) {
            form > div.action-group > input[type="reset"]:hover {
                text-decoration: underline;
           }
        }
        #btn_submit {
            border: 1px solid transparent;
            padding:16px 30px;
            border-radius: 0.25em;
            cursor: pointer;
            font-weight: 400;
            font-size: 16px;
            color: white;
            background-color: #1c273c;
            transition: all 0.1s ease-in-out;
            width: 140px;
            /* text-align: center; */
            font-family: "IBM Plex Sans", sans-serif;
        }
        @media (hover: hover) {
            form > div.action-group > input[type="button"]:hover {
                background-color: #1c273cda;
                border: 1px solid #1c273cda;
           }
        }
        /* Input Rating */
        .rating {
            user-select: none;
        }
        .rating > input[type="radio"] {
            position: absolute;
            opacity: 0;
            z-index: -999;
        }
        .rating__box {
            display: flex;
            justify-content: center;
            gap: 1em;
        }
        .rating__star {
            font-size: 3.2em;
            color: #d3d3d3;
            transition: all 0.1s ease-in-out;
        }
        .rating__star:active {
            color: #4a4a4a !important;
            text-shadow: 1px 0 5px rgba(0, 0, 0, 0.2);
        }
        @media (hover: hover) {
            .rating__star:hover {
                transform: scale(1.3);
           }
        }
        .rating > input[type="radio"]:nth-child(1):checked ~ .rating__box > .rating__star:nth-child(-n + 1) {
            color: orange;
        }
        .rating > input[type="radio"]:nth-child(1):focus-visible ~ .rating__box > .rating__star:nth-child(1) {
            outline: solid 1px black;
        }
        .rating > input[type="radio"]:nth-child(2):checked ~ .rating__box > .rating__star:nth-child(-n + 2) {
            color: orange;
        }
        .rating > input[type="radio"]:nth-child(2):focus-visible ~ .rating__box > .rating__star:nth-child(2) {
            outline: solid 1px black;
        }
        .rating > input[type="radio"]:nth-child(3):checked ~ .rating__box > .rating__star:nth-child(-n + 3) {
            color: orange;
        }
        .rating > input[type="radio"]:nth-child(3):focus-visible ~ .rating__box > .rating__star:nth-child(3) {
            outline: solid 1px black;
        }
        .rating > input[type="radio"]:nth-child(4):checked ~ .rating__box > .rating__star:nth-child(-n + 4) {
            color: orange;
        }
        .rating > input[type="radio"]:nth-child(4):focus-visible ~ .rating__box > .rating__star:nth-child(4) {
            outline: solid 1px black;
        }
        .rating > input[type="radio"]:nth-child(5):checked ~ .rating__box > .rating__star:nth-child(-n + 5) {
            color: orange;
        }
        .rating > input[type="radio"]:nth-child(5):focus-visible ~ .rating__box > .rating__star:nth-child(5) {
            outline: solid 1px black;
        }
        
        .rating-comment .rating__star {
            font-size: 20px !important;
           
            transition: all 0.1s ease-in-out;
        }

    </style>
</head>
<body>
<!-- Ratings and Review section start -->
<main>
  <form method="POST" action="{{ route('user-store-comment') }}" >
      @csrf
    <h1>Rate Us</h1>
    <p>How was your experience using our website? Your rating matter!</p>

    <div class="rating">
      <input type="radio" name="rating" id="rating-1" value="1">
      <input type="radio" name="rating" id="rating-2" value="2">
      <input type="radio" name="rating" id="rating-3" value="3">
      <input type="radio" name="rating" id="rating-4" value="4">
      <input type="radio" name="rating" id="rating-5" value="5">

      <div class="rating__box">
        <label for="rating-1" class="rating__star">&starf;</label>
        <label for="rating-2" class="rating__star">&starf;</label>
        <label for="rating-3" class="rating__star">&starf;</label>
        <label for="rating-4" class="rating__star">&starf;</label>
        <label for="rating-5" class="rating__star">&starf;</label>

      </div>
    </div>

    <div class="textarea-group" style="margin: 0 20%;">
      <label>
        <span>Comment : </span>
        <textarea id="comment-rating" placeholder="Additional feedback ..." name="comment" rows="6"></textarea>
      </label>
    </div>
    <input type="hidden" name="pcvid" value="{{$pcvid}}">
    <div class="action-group " style="align-items:center">
      <input type="submit" id="btn_submit" value="Submit">
      <!-- <input type="reset" value="Cancel"> -->
    </div>

    
  </form>
</main>   
<!-- Ratings and Review section End --> 
</body>
</html>
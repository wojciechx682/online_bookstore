

/*import DOMPurify from 'dompurify';*/

let comment = "This is the content of my variable";
let text = "<script>alert('XSS Attack!')</script>This is Text Content";
console.log("comment -> ", comment);
console.log("text -> ", text);
const sanitizedComment = DOMPurify.sanitize(comment);
const sanitizedText = DOMPurify.sanitize(text);
/*
console.log("sanitizedComment -> ", sanitizedComment);*/
console.log("sanitizedText -> ", sanitizedText);

/**
 * Override the default yii confirm dialog. This function is
 * called by yii when a confirmation is requested.
 *
 * @param message the message to display
 * @param okCallback triggered when confirmation is true
 * @param cancelCallback callback triggered when cancelled
 */
yii.confirm = function (message, okCallback, cancelCallback) {
    swal({
        title: message,
        type: 'warning',
        showCancelButton: true,
        closeOnConfirm: true,
        allowOutsideClick: true
    }, okCallback);
};

// //SweetAlert 2.0 updates => This updates not working
// yii.confirm = function (message, okCallback, cancelCallback) {                             
//     swal({
//       title: message,
//       icon: 'warning',
//       buttons: true
//     }).then((action) => {
//       if(action){
//         okCallback()
//       }
//     });
//   }
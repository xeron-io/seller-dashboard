
FilePond.registerPlugin(
  FilePondPluginImagePreview,
)

// Filepond: Image Preview
FilePond.create(document.querySelector(".image-preview-filepond"), {
  credits: null,
  allowImagePreview: true,
  allowImageFilter: false,
  allowImageExifOrientation: false,
  allowImageCrop: false,
  acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
  fileValidateTypeDetectType: (source, type) =>
    new Promise((resolve, reject) => {
      // Do custom type detection here and return with promise
      resolve(type)
    }),
})

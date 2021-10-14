function formatBytes(bytes, decimals = 2) {
    if (bytes === 0) return '0 Bytes'

    const k = 1024
    const dm = decimals < 0 ? 0 : decimals
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

    const i = Math.floor(Math.log(bytes) / Math.log(k))

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i]
}

function uuidv4() {
    return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
    );
}

function loadFiles(files, options) {
    jQuery.each(files, function(i, file) {
        let uuid = uuidv4()

        options.render({
            name: file.name,
            size: formatBytes(file.size),
            extension: file.name.substr(file.name.lastIndexOf('.') + 1),
            uuid
        })

        file.uuid = uuid
        options.formData.append(options.input.attr('name')+'['+uuid+']', file)
    })
}

$.fn.extend({
    filedrop: function (options) {
        var defaults = {
            input: null,
            render: null,
            callback: null,
            formData: new FormData()
        }
        options =  $.extend(defaults, options)
        return this.each(function() {
            var files = []
            var $this = $(this)

            // Parar as ações padrão do navegador
            $this.bind('dragover', function(event) {
                event.stopPropagation()
                event.preventDefault()

                $this.addClass('border-dashed border-2 border-primary-500').removeClass('border-0 border-transparent')
            }).bind('dragleave', function(event) {
                event.stopPropagation()
                event.preventDefault()
                $this.removeClass('border-dashed border-2 border-primary-500').addClass('border-0 border-transparent')
            })

            // Pega o evento ao soltar
            $this.bind('drop', function(event) {
                // Stop default browser actions
                event.stopPropagation()
                event.preventDefault()
                $this.removeClass('border-dashed border-2 border-primary-500').addClass('border-0 border-transparent')

                // Obtém os arquivos que estão sendo soltos
                files = event.originalEvent.target.files || event.originalEvent.dataTransfer.files

                // Converta o arquivo carregado em URL de dados e passe o retorno de chamada
                if(options.render) {
                    loadFiles(files, options)
                }

                if (options.callback) {
                    options.callback(options)
                }

                return false
            })

            if (options.input) {
                $this.on('click', function() {
                    options.input.click()
                })

                options.input.on('change', function () {
                    loadFiles(options.input[0].files, options)

                    if (options.callback) {
                        options.callback(options)
                    }
                })
            }
        })
    }
})

<template>
    <div class="form-control">
        <label for="editorjs">Содержание</label>
        <div id="editorjs"></div>
    </div>
</template>

<script>
import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import List from '@editorjs/list';
import Embed from '@editorjs/embed';
import Table from '@editorjs/table';
import EditorJsFm from "file-manager-editor-js/src/lib/editor-js-connect";
import "file-manager-editor-js/src/style/main.scss";
import {useStore} from "vuex";

export default {
    name: "AppEditor",

    setup() {
        const store = useStore();

        const editor = new EditorJS({
            tools: {
                header: Header,
                list: List,
                embed: Embed,
                table: Table,
                fileManager: {
                    class: EditorJsFm,
                    config: {
                        lang:"ru" || "en",
                        token: store.getters["auth/token"],
                        apiUrl: "/storage",
                        uploadUrl: "/storage",
                        routes: {
                            allFoldersOrCurentFolder: 'uploads',
                            // subFoldersAndFiles: 'filemanager/folders/${_id}',
                            // updateFolder: 'filemanager/folder/${_id}',
                            // deleteFolder: 'filemanager/folder/${_id}',
                            // createFolder: 'filemanager/folders',
                            updateFile: 'uploads/file/${_id}',
                            deleteFile: 'uploads/file/${_id}',
                            uploadFile: 'uploads/folders/${_id}/file'
                        }
                    }
                }
            },
        });
    }
}
</script>

<style scoped lang="scss">

</style>

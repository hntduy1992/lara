/**
 * Lớp giúp sắp xếp danh sách phẳng các đối tượng thành một danh sách liền kề
 * theo cấu trúc cha-con và thuộc tính 'sort', có thêm trường 'level' để xác định cấp độ.
 */
export default class HierarchicalSorter {
    /**
     * @param {string} idKey - Tên thuộc tính ID duy nhất (mặc định: 'id').
     * @param {string} parentIdKey - Tên thuộc tính ID cha (mặc định: 'parent_id').
     * @param {string} sortKey - Tên thuộc tính dùng để sắp xếp các phần tử cùng cấp (mặc định: 'sort').
     * @param {(number|string)} rootId - Giá trị ID cha của các nút gốc (mặc định: null).
     * @param {string} levelKey - Tên trường mới để lưu cấp độ (mặc định: 'level').
     */
    constructor(idKey = 'id', parentIdKey = 'parent_id', sortKey = 'sort', rootId = null, levelKey = 'level') {
        this.idKey = idKey;
        this.parentIdKey = parentIdKey;
        this.sortKey = sortKey;
        this.rootId = rootId;
        this.levelKey = levelKey; // Thuộc tính mới
        this.childrenMap = new Map();
        this.result = [];
    }

    // ... (Hàm _buildAndSortMap không thay đổi) ...
    _buildAndSortMap(flatList) {
        flatList.forEach(item => {
            const parentId = item[this.parentIdKey];
            if (!this.childrenMap.has(parentId)) {
                this.childrenMap.set(parentId, []);
            }
            // Tạo một bản sao để tránh thay đổi dữ liệu gốc
            this.childrenMap.get(parentId).push({...item});
        });

        for (const children of this.childrenMap.values()) {
            children.sort((a, b) => a[this.sortKey] - b[this.sortKey]);
        }
    }


    /**
     * Sắp xếp và trả về danh sách liền kề mới.
     * @param {Array<Object>} flatList - Danh sách các đối tượng đầu vào.
     * @returns {Array<Object>} - Danh sách liền kề đã được sắp xếp, có thêm 'level'.
     */
    sort(flatList) {
        this.childrenMap = new Map();
        this.result = [];

        if (!flatList || flatList.length === 0) {
            return [];
        }

        this._buildAndSortMap(flatList);

        const rootNodes = this.childrenMap.get(this.rootId) || [];

        // Bắt đầu đệ quy từ cấp 1 (level: 1)
        rootNodes.forEach(root => {
            this._appendChildrenRecursively(root, 1);
        });

        return this.result;
    }

    /**
     * (Internal Method) Hàm đệ quy để thêm nút hiện tại và các nút con vào result.
     * @param {Object} node - Nút hiện tại.
     * @param {number} currentLevel - Cấp độ hiện tại của nút.
     */
    _appendChildrenRecursively(node, currentLevel) {
        // 1. Gán cấp độ cho nút
        node[this.levelKey] = currentLevel;

        // 2. Thêm nút hiện tại vào kết quả
        this.result.push(node);

        // 3. Lấy danh sách các nút con
        const children = this.childrenMap.get(node[this.idKey]);

        // 4. Đệ quy, tăng cấp độ lên 1
        if (children) {
            const nextLevel = currentLevel + 1;
            children.forEach(child => {
                this._appendChildrenRecursively(child, nextLevel);
            });
        }
    }
}

const buildTree = (list) => {
    // 1. Nhóm các mục theo parent_id
    const grouped = list.reduce((acc, item) => {
        const parentId = item['parent_id'] === null || item[parent_id] === 0 ? 0 : item[parent_id];
        if (!acc[parentId]) {
            acc[parentId] = [];
        }
        acc[parentId].push(item);
        return acc;
    }, {});

    /**
     * Hàm đệ quy để xây dựng cấu trúc cây
     * @param {number|string|null} parentId ID của nút cha hiện tại.
     * @returns {Array<Object>} Mảng các nút con.
     */
    function buildTreeRecursive(parentId) {
        // Lấy danh sách các con trực tiếp của parentId hiện tại.
        const children = grouped[parentId] || [];

        return children.map(item => {
            // Sao chép đối tượng để tránh thay đổi dữ liệu gốc
            const node = {...item};

            // Gọi đệ quy để tìm con của nút hiện tại
            const nestedChildren = buildTreeRecursive(node[idKey]);

            // Nếu có con, thêm vào khóa 'children'
            if (nestedChildren.length > 0) {
                node['children'] = nestedChildren;
                // Thêm cờ cho v-treeview hoặc xử lý tùy chỉnh
                node.is_parent = true;
            } else {
                node.is_parent = false;
            }

            return node;
        });
    }

    // Bắt đầu xây dựng cây từ cấp gốc (parent_id = 0 hoặc null/undefined)
    // Lưu ý: Tôi dùng 0 làm ID giả định cho cấp gốc (Root)
    return buildTreeRecursive(0);
}
export default buildTree()
